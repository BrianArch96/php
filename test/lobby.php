<?php include ('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<meta http-equiv="refresh" content="10" > 
<body>
	<div class = "header">
		<h2>Lobby Listing</h2>
	</div>


	<form method="POST" >
		<label for="Manufacturer"> Players : </label>
  <select id="cmbMake" name="Make"     onchange="document.getElementById('selected_text').value=this.options[this.selectedIndex].text">
     <option value="0">Select a Player</option>
     <?php foreach($_SESSION['users'] as $sir){
		?> <option value = "0"> <?php echo $sir ?> </option> <?php  
	 
	}?>

   </select>
<input type="hidden" name="selected_text" id="selected_text" value="" />
<input type="submit" name="search" value="Play!"/>
	
	<div class="input-group">
	<button type = "submit" name="return" class = "btn">Return to Menu</button>
		</div>
	</form>



</body>
</html>