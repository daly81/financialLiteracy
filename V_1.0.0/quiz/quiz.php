<html>
<head>
<title>MOD 1 QUIZ</title>
<meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- css -->
  <link href="../user_account/css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link href="../user_account/css/style.css" rel="stylesheet" media="screen">
  <link href="../user_account/color/default.css" rel="stylesheet" media="screen">
  <script src="../user_account/js/modernizr.custom.js"></script>


</head>

<body onload="checkLoginState(), getUserInfo()">


<?php
include '../connect.php';
session_start(); 
//Get Best score by user
$result = new stdClass; 
function get_best_score(){
    global $result;
	$con = db_connect();
	$res = new stdClass();
	$stm = $con->prepare('
		SELECT *
		FROM quiz
		WHERE user_id = :user_id && quiz_id = 1; ; 
	');
	
	$res->success = $stm->execute(array(
		':user_id' => $_SESSION['user_id']
	));
	$result = $stm->fetch(PDO::FETCH_ASSOC);
	
	if(empty($result)){
		echo "has not yet been recorded."; 
	}else{
		echo "is " . $result['percent'] . " / 100";
	};
	
	
};

function readAnswerKey($answertxt) {
	$answerKey = array();
	
	// If the answer key exists and is readable, read it into an array.
	if (file_exists($answertxt) && is_readable($answertxt)) {
		$answerKey = file($answertxt);
	}
	
	return $answerKey;
}


// Read the questions file and return an array of arrays (questions and choices)
// Each element of $displayQuestions is an array where first element is the question 
// and second element is the choices.

function readQuestions($questiontxt) {
	$displayQuestions = array();
	
	if (file_exists($questiontxt) && is_readable($questiontxt)) {
		$questions = file($questiontxt);
	
		// Loop through each line and explode it into question and choices
		foreach ($questions as $key => $value) {
			$displayQuestions[] = explode(":",$value);
		}				
	}
	else { echo "Error finding or reading questions file."; }
	
	return $displayQuestions;
}


// Take our array of exploded questions and choices, show the question and loop through the choices.
function displayTheQuestions($questions) {
	if (count($questions) > 0) {
		foreach ($questions as $key => $value) {
			
			echo '<div class="container">';
				echo'<div class="row question">'; 
					echo "<b>$value[0]</b><br/><br/>";
				echo "</div>";
			echo "</div>";
			
			// Break the choices appart into a choice array
			$choices = explode(",",$value[1]);
			
			// For each choice, create a radio button as part of that questions radio button group
			// Each radio will be the same group name (in this case the question number) and have
			// a value that is the first letter of the choice.
			
			foreach($choices as $value) {
				$letter = substr(trim($value),0,1);
				
				echo '<div class="container">';
					echo'<div class="row">'; 
						echo '<label class="input-group q-group">' ;
							echo '<div class="input-group-text q-group-text">'; 
								echo "<input class=\"quiz_input\" type=\"radio\" name=\"$key\" value=\"$letter\">$value<br/>" ;
							echo '</div>';
						echo "</label>";
					echo "</div>";
				echo "</div>";	
			}
			
			echo "<br/>";
		}
	}
	else { echo "No questions to display."; }
}


// Translates a precentage grade into a letter grade based on our customized scale.
function translateToGrade($percentage) {

	if ($percentage >= 90.0) { return "A"; }
	else if ($percentage >= 80.0) { return "B"; }
	else if ($percentage >= 70.0) { return "C"; }
	else if ($percentage >= 60.0) { return "D"; }
	else { return "F"; }
}

?>

<!-- CONTENT MAIN-->
    <div class="container-fluid">
        <div class="row header">
            <div class="col col-header">
                Welcome to Quiz 1
            </div>
        </div>
    </div><!-- Container-fluid -->
	<div class="container-fluid">
		<div class="row">
			<a href="../user_account/modOne.html" class="btn btn-info">Back</a>
		</div>
		<div class="score">
			<div class="row">
				<div id="displayScore">Your best Score for this quiz <?php get_best_score() ?></div>
			</div>
		</div>
	</div>

	<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
	
	
<?php

	// Load the questions from the questions file
	$loadedQuestions = readQuestions("mod_1/questions.txt");
	
	// Display the questions
	displayTheQuestions($loadedQuestions);
?>
<div class="container">
	<div class="row question">
		<input class="btn btn-info" type="submit" name="submitquiz" value="Submit Quiz"/>
	</div>
</div>


<?php

// This grades the quiz once they have clicked the submit button
if (isset($_POST['submitquiz'])) {

	// Read in the answers from the answer key and get the count of all answers.
	$answerKey = readAnswerKey("mod_1/answerkey.txt");
	$answerCount = count($answerKey);
	$correctCount = 0;


	// For each answer in the answer key, see if the user has a matching question submitted
	foreach ($answerKey as $key => $keyanswer) {
		if (isset($_POST[$key])) {
			// If the answerkey and the user submitted answer are the same, increment the 
			// correct answer counter for the user
			if (strtoupper(rtrim($keyanswer)) == strtoupper($_POST[$key])) {
				$correctCount++;
			};
		};
	};
	
	
	if ($answerCount > 0) {

		// If we had answers in the answer key, translate their score to percentage
		// then pass that percentage to our translateGrade function to return a letter grade.
		
		echo '<div class="container">';
			echo '<div class="score">'; 
				echo '<div class="row">';
					echo '<h2>Grade</h2>'; 
					echo "Total Questions: $answerCount<br/>";
					echo "Number Correct: $correctCount<br/><br/>";
					
					$percentage = round((($correctCount / $answerCount) * 100),1);
					echo "Total Score: $percentage% (Grade: " . translateToGrade($percentage) . ")<br/><br/>";
					echo '<button id="return" type="button" class="btn btn-info">Return to Module 1</button>'; 
				echo '</div>';
			echo '</div>'; 
		echo '</div>'; 
		
	}
	else {
		// If something went wrong or they failed to answer any questions, we have a score of 0 and an "F"
		echo "Total Score: 0 (Grade: F)";
	}
	
	
	$con = db_connect(); 
	$quiz_id = 1;
    global $result;
	
    if((!empty($result)) && $result['percent'] < $percentage){
       $stm = $con->prepare('
			UPDATE quiz
			SET percent=:percent, user_id=:user_id, quiz_id=:quiz_id
			WHERE record_id ='. $result['record_id'] .';'
		);
    } else if($result['percent'] > $percentage){
        $stm = $con->prepare('
			UPDATE quiz
			SET percent=percent, user_id=user_id, quiz_id=quiz_id
			WHERE record_id ='. $result['record_id'] .';'
		);
    } else if(empty($result)) {
        $stm = $con->prepare('
            INSERT INTO quiz (user_id, percent, quiz_id)
            VALUES (:user_id, :percent, :quiz_id);'
        );
    };
	$stm->execute(array(
	  ':user_id' => $_SESSION['user_id'],
	  ':percent' => $percentage,
	  ':quiz_id' => $quiz_id
	));
	//echo json_encode($res);   

}

?>

</form>


	<script src="../user_account/js/jquery.js"></script>
	<script src="../user_account/js/bootstrap.min.js"></script>
	<script src="../user_account/js/jquery.smooth-scroll.min.js"></script>
	<script src="../user_account/js/jquery.dlmenu.js"></script>
	<script src="../user_account/js/wow.min.js"></script>
	<script src="../user_account/js/custom.js"></script>
	<script src="../user_account/contactform/contactform.js"></script>
	<script>
		
		$(".quiz_input").click(function(){
			if ($('.quiz_input').is(':checked')) {
				$('input:not(:checked)').parent().removeClass("active_radio");
                $('input:checked').parent().addClass("active_radio"); 
            }
		})
		$('#return').click(function(){
			window.location.replace("../user_account/modOne.html");
		})
	</script>


</body>
</html>