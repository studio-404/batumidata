<?php if(!defined("DIR")){ exit(); }
class sendemailfromserver
{
	public function index($args)
	{
		require_once "_plugins/PHPMailer/PHPMailerAutoload.php";  

		$out = false;	
		$mail = new PHPMailer;
		
		//$mail->SMTPDebug = 3; 

		$mail->isSMTP(); 
		$mail->CharSet = 'UTF-8';
		$mail->Host = $args['email_host'];
		$mail->SMTPAuth = true;
		$mail->Username = $args['email_username'];
		$mail->Password = $args['email_password'];
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;

		$mail->setFrom($args['email_username'], $args['email_name']);
		$mail->addAddress($args["sendTo"]); 
		$mail->addReplyTo($args['email_username']);
		// $mail->addCC('cc@example.com');
		// $mail->addBCC('bcc@example.com');

		if(isset($args['attachment'])){
			$mail->addAttachment(DIR.$args['attachment']);
		}
		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');   
		$mail->isHTML(true);                                  

		$mail->Subject = $args['subject'];
		$mail->Body = $args['body'];
		// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
		    $out = false;
		} else {
		    $out = true;
		}

		return $out;
	}
}