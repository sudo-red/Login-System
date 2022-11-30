<?php 
include('func.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Verify User</title>
	<link rel="stylesheet" type="text/css" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
	<div class="header">
		<h2>OTP Verification</h2>
	</div>

	<form method="post" action="verify.php">
		<?php include('errors.php'); ?>
		<div class="input-group">
			<label>Enter Code sent to your email: </label>
			<input type="number" name="otp" min="0000" max="9999">
		</div>

		<div class="input-group">
			<button type="submit" class="btn" name="verifyotp">Submit</button>
		</div>
	</form>
</body>
</html>