<?php
//all form functions are here
//starts session
session_start();

// initializing variables
$errors = array(); 
$username = "";
$email    = "";

// connecting to the database 
// also sets variable for connecting the db in functions
$db = mysqli_connect('localhost', 'root', '', 'info');

// REGISTER USER
if (isset($_POST['register'])) 
{
	// receive input from the form
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$password = mysqli_real_escape_string($db, $_POST['password']);
	$password2 = mysqli_real_escape_string($db, $_POST['password2']);

	// checks is form is correctly filled
	// array_push()) allows for the corresponding of errors to $errors array (see errors.php)
	if (empty($username)) { array_push($errors, "Username is required"); }
	if (empty($email)) { array_push($errors, "Email is required"); }
	if (empty($password)) { array_push($errors, "Password is required"); }
	if ($password != $password2) { array_push($errors, "Passwords do not match"); }

	// checks if user and email already exists in the database
	$check = "SELECT * FROM input WHERE username='$username' OR email='$email' LIMIT 1";
	$result = mysqli_query($db, $check);
	$user = mysqli_fetch_assoc($result);

	// if username/email already exists:
	if($user)
	{
		if ($user['username'] === $username) 
		{ array_push($errors, "Username already exists"); }
		if ($user['email'] === $email) 
		{ array_push($errors, "Email already exists"); }
	}

	// Registers user if there are no errors encountered
	if (count($errors) == 0) 
	{
		// encrypts password before saving in the database
		$password = md5($password);
		// inserts form info to database
		$query = "INSERT INTO input (username, email, password) 
		  VALUES('$username', '$email', '$password')";
		mysqli_query($db, $query);
		$_SESSION['email'] = $email;
		include('mail.php');
	}
}

// LOGIN USER
if (isset($_POST['userlogin'])) 
{
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$password = mysqli_real_escape_string($db, $_POST['password']);

	//checks if email/password field is empty when logging in
	if (empty($email) OR empty($password)) 
	{ 
		array_push($errors, "Email/Password is required"); 
	}

	// checks if email and password have a match in the database
	// after no errors are encountered
	if (count($errors) == 0) 
	{
		$password = md5($password);
		$query = "SELECT * FROM input WHERE email='$email' AND password='$password'";
		$results = mysqli_query($db, $query);
		if (mysqli_num_rows($results) == 1) 
		{
			//retrieves email from login
			$results = mysqli_query($db, $query); 
			$_SESSION['email'] = $email;
			
			//includes otp generation
			include('mail.php');
		}
		else 
		{
			array_push($errors, "Wrong email/password combination");
		}
	}
}

// VERIFICATION AFTER OTP
if (isset($_POST['verifyotp'])) 
{
	//removes undefined array key
	// receives otp code input from user
	$otp = $_POST['otp'];
	
	// checks is otp field submitted is empty
	if (empty($otp)) 
	{ array_push($errors, "OTP required"); }

		if (count($errors) == 0)
		{   
			// if not empty --
			// checks otp code in the database matches user input
			$query = "SELECT * FROM input WHERE otp='$otp'";
			$results = mysqli_query($db, $query);
			if (mysqli_num_rows($results) == 1) 
			{
				$_SESSION['success'] = "Sucessfully Connected";
				header('location: index.php');
			}
			else 
			{
				array_push($errors, "Wrong OTP Code");
			}
		}
}

?>