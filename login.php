<?php include('func.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
	<div class="header">
		<h2>Login</h2>
	</div>

	<form method="post" action="login.php">
		<?php include('errors.php'); ?>
		<div class="input-group">
			<label>Email</label>
			<input type="text" name="email" >
		</div>
		
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password">
		</div>
		
		<div class="input-group">
			<button type="submit" class="btn" name="userlogin">Login</button>
		</div>
		
		<p>
		No account yet? Click here to <a href="register.php" style="color: green;">SIGN UP</a>
		</p>
	</form>
</body>
</html>