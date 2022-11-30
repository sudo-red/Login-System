<?php include('func.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign up</title>
	<link rel="stylesheet" type="text/css" href="style.css?v=<?php echo time(); ?>">
</head>
<body>

<!-- Header for form-->
<div class="header">
	<h2>Sign Up</h2>
</div>

<!-- REGISTRATION FORM -->
<form method="post" action="register.php">
	<?php include('errors.php'); ?>
	<div class="input-group">
	<label>Username</label>
	<input type="text" name="username" value="<?php echo $username; ?>">
	</div>
	
	<div class="input-group">
	<label>Email</label>
	<input type="email" name="email" value="<?php echo $email; ?>">
	</div>
	
	<div class="input-group">
	<label>Password</label>
	<input type="password" name="password">
	</div>
	
	<div class="input-group">
	<label>Confirm password</label>
	<input type="password" name="password2">
	</div>
	
	<div class="input-group">
	<button type="submit" class="btn" name="register">Register</button>
	</div>
	
	<p>Already have an account? <a href="login.php">LOG IN</a></p>
</form>
</body>
</html>