<html>
<head>
<title>MOD 1 QUIZ</title>
</head>

<body>


<?php

	
// Read answerkey.txt file for the answers to each of the questions.
$answertxt = fopen('answerkey.txt', "r"); 

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
$questiontxt = fopen('questions.txt', "r"); 

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
			echo "<b>$value[0]</b><br/><br/>";
			
			// Break the choices appart into a choice array
			$choices = explode(",",$value[1]);
			
			// For each choice, create a radio button as part of that questions radio button group
			// Each radio will be the same group name (in this case the question number) and have
			// a value that is the first letter of the choice.
			
			foreach($choices as $value) {
				$letter = substr(trim($value),0,1);
				echo "<input type=\"radio\" name=\"$key\" value=\"$letter\">$value<br/>";
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

<h2>Welcome to the Dream In Code Example Online Quiz!</h2>
<h4>Please complete the following questions as accurately as possible.</h4>

<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

<?php
	// Load the questions from the questions file
	$loadedQuestions = readQuestions("questions.txt");
	
	// Display the questions
	displayTheQuestions($loadedQuestions);
?>

<input type="submit" name="submitquiz" value="Submit Quiz"/>


<?php

// This grades the quiz once they have clicked the submit button
if (isset($_POST['submitquiz'])) {

	// Read in the answers from the answer key and get the count of all answers.
	$answerKey = readAnswerKey("answerkey.txt");
	$answerCount = count($answerKey);
	$correctCount = 0;


	// For each answer in the answer key, see if the user has a matching question submitted
	foreach ($answerKey as $key => $keyanswer) {
		if (isset($_POST[$key])) {
			// If the answerkey and the user submitted answer are the same, increment the 
			// correct answer counter for the user
			if (strtoupper(rtrim($keyanswer)) == strtoupper($_POST[$key])) {
				$correctCount++;
			}
		}
	}


	// Now we know the total number of questions and the number they got right. So lets spit out the totals.
	echo "<br/><br/>Total Questions: $answerCount<br/>";
	echo "Number Correct: $correctCount<br/><br/>";

	if ($answerCount > 0) {

		// If we had answers in the answer key, translate their score to percentage
		// then pass that percentage to our translateGrade function to return a letter grade.
		$percentage = round((($correctCount / $answerCount) * 100),1);
		echo "Total Score: $percentage% (Grade: " . translateToGrade($percentage) . ")<br/>";
	}
	else {
		// If something went wrong or they failed to answer any questions, we have a score of 0 and an "F"
		echo "Total Score: 0 (Grade: F)";
	}
}

?>

</form>

</body>
</html>