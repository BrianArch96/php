<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
	<title> User registration system using PHP and MySQL</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="header">
		<h2>Registration</h2>
	</div>
	<form method="post" action = "tictac.php">
		<div class = "input-group">
			<label>Username</label>
			<input type="text" name="username">
		</div>
		<div class = "input-group">
			<label>Email</label>
			<input type = "text" name = "email">
		</div>
		<div class = "input-group">
			<label>Password</label>
			<input type="password" name="password">
		</div>
		<div class="input-group">
		<button type = "submit" name="register" class = "btn">Register</button>
		</div>
		<p>Already a member? <a href="login.php">Sign in</p>



	</form>

</body>
</html>