<?php
//error_reporting(E_ALL);
require 'PHPMailer-master/PHPMailerAutoload.php';

$res = new stdClass();


$from = "idaly81@gmail.com";
$to = $_POST['email'];
$subject = "Change Password";
$message = "Click the link below to change your password";


$mail = new PHPMailer;

$mail->SMTPDebug = 3;                                     // Enable verbose debug output

$mail->isSMTP();                                            // Set mailer to use SMTP
$mail->Host = 'localhost';    // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                                     // Enable SMTP authentication
$mail->Username = 'ian';                  // SMTP username
$mail->Password = 'IvD.1614';                               // SMTP password
$mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                          // TCP port to connect to
$mail->setFrom($from);
$mail->addAddress($to);                                     // Name is optional
$mail->addReplyTo('idaly81@gmail.com', 'Information');

$mail->isHTML(true);                                         // Set email format to HTML

$mail->Subject = $subject;
$mail->Body    = $message;
$mail->Body = "https://sevengenerationsfinancial.com/secret/chagePassword.html";
$mail->AltBody = $message;

$sent = $mail->send();

if(!$sent) {
    echo "Message could not be sent.\n";
    echo 'Mailer Error: ' . $mail->ErrorInfo . "\n";
var_dump($mail);
} else {
    $res->success = true;
    echo json_encode($res);
}


?>
