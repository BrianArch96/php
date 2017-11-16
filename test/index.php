<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title> User registration system using PHP and MySQL</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="header">
		<h2>Home page</h2>
	</div>
	<div class = "content"> 
		<?php if (isset($_SESSION['success'])): ?>
			<div class = "error success">
				<h3>
					<?php
						echo $_SESSION['success'];
						unset($_SESSION['success']);
						?>
				</h3>	
			</div>
			<?php endif ?>
			<form method = "post" action = "index.php">
			<?php if (isset($_SESSION["username"])): ?>
			<p>Welcome  <strong><?php echo $_SESSION['username']; ?></strong	>!</p>
			<?php endif ?>
			<div class = "input-group">
			<button type = "submit" name="join-game" class = "btn">Join a game!</button>
			</div>
			<div class = "input-group">
			<button type = "submit" name="create-game" class = "btn">Create a game!</button>
		</div>
					<div class = "input-group">
			<button type = "submit" name="leaderboards" class = "btn">Check the leaderboards!</button>
		</div>
			<p><a href = "index.php?logout" style ="color: red;">Logout</a></p>
	</div>
		</form>
</body>
</html>