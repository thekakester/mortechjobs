<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once("PHPMailer/src/Exception.php");
include_once("PHPMailer/src/PHPMailer.php");
include_once("PHPMailer/src/SMTP.php");

function email($to,$subject,$body) {
	try {
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';

		$mail->Host       = "smtp.us.exg7.exghost.com"; // SMTP server example
		$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->Port       = 587;                    // set the SMTP port for the GMAIL server
		$mail->Username   = "labels@mortechdesign.com"; // SMTP account username example
		$mail->Password   = "M0rt3chEmailPasssw0rd";
		$mail->setFrom('labels@mortechdesign.com', 'Mortech Noreply');
		$mail->addAddress($to);
		$mail->addReplyTo('sclements@mortechdesign.com', 'Sarah Clements');
		//Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $subject;
		$mail->Body    = $body;

		$mail->send();
	} catch (Exception $e) {
		echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
	}
}
?>