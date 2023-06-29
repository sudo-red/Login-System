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
	$mail->Username = "";
// Set gmail password
	$mail->Password = "";
// Email subject
	$mail->Subject = "Your OTP Code";
// Set sender email
	$mail->SetFrom("no-reply@gmail.com", "OTP Code");
//Enable HTML
	$mail->isHTML(true);
// generates random otp code
	$otp = rand(1000,9999);
// Email body
	$mail->Body = 
	'<div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
			<div style="margin:50px auto;width:70%;padding:20px 0">
				<div style="border-bottom:1px solid #eee">
				<a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">Software Engineering</a>
				</div>
			<p style="font-size:1.1em">Hi there!</p>
			<p>Use the following OTP to complete your registration.</p>
			<h2 style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">'.$otp.'</h2>
			<hr style="border:none;border-top:1px solid #eee" />
			</div>
		</div>';
// Add recipient
	$mail->addAddress($email);
// Sends email
	if ( $mail->send() ) 
	{
		// stores otp to database
		// connecting to database
		$db = mysqli_connect('localhost', 'root', '', 'info');
		
		// selects user info from database and updates OTP
        $sql = "UPDATE input1 SET otp='".$otp."' WHERE email='".$email."'";
        mysqli_query($db, $sql);
		
		// redirect to otp code verification 
		// if mail sending is a success 
		header('location: verify.php');
	}else{
		echo "Message could not be sent. Mailer Error: ";
	}
?>
