<!DOCTYPE html>
<html>
<head>
	<title>Main page</title>
</head>
<body>
	<?php
		if((isset($_SESSION['username']) && isset($_SESSION['password'])) ||
		(isset($_COOKIE['login']) && isset($_COOKIE['password'])))
			header("Location: edit.php");
	?>
	<h1>Log in</h1>
	<form method="POST" action="login.php">
		<p>Enter Username</p>
		<input type="text" name="login" required>
		<p>Enter Password</p>
		<input type="password" name="password" required><br><br>
		<button name="Log">Login</button>
	</form>
	<p>Or, if you do not have an account</p>
	<h1>Registration</h1>
	<form method="POST" action="registration.php">
		<p>Enter Username</p>
		<input type="text" name="loginreg" required>
		<p>Enter your e-mail</p>
		<input type="e-mail" name="e-mailreg" placeholder="example@gmail.com" required>
		<p>Enter Password</p>
		<input type="password" name="passwordreg" required=><br><br>
		<button name="Reg">Registration</button>
	</form>
</body>
</html>