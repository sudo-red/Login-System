<?php 
include('func.php');
if (!isset($_SESSION['success'])) 
{
	header('location: login.php');
}
if (isset($_GET['logout'])) 
{
	session_destroy();
	unset($_SESSION['success']);
	header("location: login.php");
}
?>
<!-- Login Home Page -->
<!DOCTYPE html>
<html>
<head>
<title>Home</title>
<link rel="stylesheet" type="text/css" href="style.css?v=<?php echo time(); ?>">
</head>
<body>

<div class="header">
	<h2>Welcome</h2>
</div>

<div class="content">
	<!-- notification message -->
	<?php if (isset($_SESSION['success'])) : ?>
	<div class="error success" >
		<h3>
		<?php 
		echo $_SESSION['success']; 
		?>
		</h3>
	</div>

	<!-- user information -->
	
	<h3>You are successfully signed in.</h3>
	<h3>Click below to sign out</h3>
	
	<br/><br/><p><a href="index.php?logout='1'" class="btn" name="logout">Log out</a></p>
	<?php endif ?>
</div>

</body>
</html>