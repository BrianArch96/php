<?php include('server.php'); ?>
<?php include('gamelogic.php');?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<h3>Hi me!</h3>
	<form method="post" action = "game.php">
		<div class = input-group>
	<button type = "submit" name="button1" style = "background:<?php echo $_SESSION['color']?>" class = "btn">Button!</button>
	<button type = "submit" name="button2" style = "background:<?php echo $_SESSION['color1']?>" class = "btn">Button!</button>
	<button type = "submit" name="button3" style = "background:<?php echo $_SESSION['color2']?>" class = "btn">Button!</button>
	<button type = "submit" name="button4" style = "background:<?php echo $_SESSION['color3']?>" class = "btn">Button!</button>
	<button type = "submit" name="button5" style = "background:<?php echo $_SESSION['color4']?>" class = "btn">Button!</button>
	<button type = "submit" name="button6" style = "background:<?php echo $_SESSION['color5']?>" class = "btn">Button!</button>
	<button type = "submit" name="button7" style = "background:<?php echo $_SESSION['color6']?>" class = "btn">Button!</button>
	<button type = "submit" name="button8" style = "background:<?php echo $_SESSION['color7']?>" class = "btn">Button!</button>
	<button type = "submit" name="button9" style = "background:<?php echo $_SESSION['color8']?>" class = "btn">Button!</button>
	<button type = "submit" name ="update"   >Update!</button>
	<button type = "submit" name = "restart" >Start a new game</button>
	</div>
	</form>
</head>
<body>

</body>
</html>