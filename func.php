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
	
	//password checker
	$number = preg_match('@[0-9]@', $password);
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);

	// checks is form is correctly filled
	// array_push()) allows for the corresponding of errors to $errors array (see errors.php)
	if (empty($username)) { array_push($errors, "- Username is required"); }
	if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) { array_push($errors, "- Email is invalid"); }
	if (empty($password)) { array_push($errors, "- Password is required"); }
	if ($password != $password2) { array_push($errors, "- Passwords do not match"); }
	if(strlen($password) < 8 ) { array_push($errors, "- Password must be at least 8 characters in length."); } 
	if(!$number || !$uppercase || !$lowercase || !$specialChars) { array_push($errors, "- Password must contain at least one number, one upper case letter, one lower case letter and one special character."); } 

	// checks if user and email already exists in the database
	$check = "SELECT * FROM input1 WHERE username='$username' OR email='$email' LIMIT 1";
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
		$query = "INSERT INTO input1 (username, email, password) 
		  VALUES('$username', '$email', '$password')";
		mysqli_query($db, $query);
		$_SESSION['email'] = $email;
		$_SESSION['username'] = $username;
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
		$query = "SELECT * FROM input1 WHERE email='$email' AND password='$password'";
		$results = mysqli_query($db, $query);
		if (mysqli_num_rows($results) == 1) 
		{
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
			$query = "SELECT * FROM input1 WHERE otp='$otp'";
			$results = mysqli_query($db, $query);
			if (mysqli_num_rows($results) == 1) 
			{
				mysqli_fetch_assoc($results);
				$_SESSION['success'] = "Account Verified";
				header('location: index.php');
			}
			else 
			{
				array_push($errors, "Wrong OTP Code");
			}
		}
}
?>