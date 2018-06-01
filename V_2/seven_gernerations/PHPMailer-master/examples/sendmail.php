<pre><?php
//error_reporting(E_ALL);
require '../PHPMailerAutoload.php';


$to = "idaly81@gmail.com"; 
$from = $_POST['email']; 
$name = $_POST['name'];
$subject = $_POST['subject'];
$message = $_POST['message'];


$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                                     // Enable verbose debug output

$mail->isSMTP();                                            // Set mailer to use SMTP
$mail->Host = 'a2plcpnl0189.prod.iad2.secureserver.net';    // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                                     // Enable SMTP authentication
$mail->Username = 'info@trumpdodgers.com';                  // SMTP username
$mail->Password = 'y3p?eCha';                               // SMTP password
$mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                          // TCP port to connect to
$mail->setFrom('info@trumpdodgers.com', 'Information');
$mail->addAddress($to);                                     // Name is optional
$mail->addReplyTo('info@trumpdodgers', 'Information');

$mail->isHTML(true);                                        // Set email format to HTML

$mail->Subject = $_POST['subject'];
$mail->Body    = $_POST['message'];
$mail->AltBody = $_POST['message'];

//echo "---Presend---";
$sent = $mail->send();
//echo "---PostSend---";
//echo $sent;
//echo "---Result---\n";

if(!$sent) {
    echo "Message could not be sent.\n";
    echo 'Mailer Error: ' . $mail->ErrorInfo . "\n";
var_dump($mail);
} else {
    echo 'Message has been sent';
}
?>
</pre>
