<?php
//PHPMailer Function with OTP
// Include required PHPMailer files
	require 'includes/PHPMailer.php';
	require 'includes/SMTP.php';
	require 'includes/Exception.php';
// Define name spaces
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
// Create instance of PHPMailer
	$mail = new PHPMailer();
// Set mailer to use smtp
	$mail->isSMTP();
// Define smtp host
	$mail->Host = "smtp.gmail.com";
// Enable smtp authentication
	$mail->SMTPAuth = true;
// Set smtp encryption type (ssl/tls)
	$mail->SMTPSecure = "tls";
// Port to connect smtp
	$mail->Port = "587";
// Set gmail username
	$mail->Username = "stellacarlin19@gmail.com";
// Set gmail password
	$mail->Password = "hngmlftpfsjwujhj";
// Email subject
	$mail->Subject = "Your OTP Code";
// Set sender email
	$mail->setFrom('stellacarlin19@gmail.com');
//Enable HTML
	$mail->isHTML(true);
// generates otp code
	$otp = rand(1000,9999);
// Email body
	$mail->Body = '<p> Your verification code is: <b style="font-size: 30px;">' . $otp . '</b></p>';
// Add recipient
	$mail->addAddress($email);
// Sends email
	if ( $mail->send() ) 
	{
		// stores otp to database
		// connecting to database
		$db = mysqli_connect('localhost', 'root', '', 'info');
		
		// selects user info from database and updates OTP
        $sql = "UPDATE input SET otp='".$otp."' WHERE email='".$email."'";
        mysqli_query($db, $sql);
		
		// redirect to otp code verification 
		// if mail sending is a success 
		header('location: verify.php');
	}else{
		echo "Message could not be sent. Mailer Error: ";
	}
?>