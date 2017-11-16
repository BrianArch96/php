<?php include('server.php');  ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<h2>Wait here you retard</h2>

	<?php
$page = $_SERVER['PHP_SELF'];
$sec = "1";
?>
<html>
    <head>
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    </head>
    <body>
    <?php
       // echo "Watch the page reload itself in 1 second!";
        $username = $_SESSION['username'];
         $query = "SELECT * FROM gamesearch where username = '$username'";
   		 $results = mysqli_query($db,$query);
   		 if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 //echo "hi";
   		 $var = 0;
   		 $ri=mysqli_fetch_array($results);
   		// print_r($ri);

   		 	$var = $ri['isFound'];

   		 if($var ==1){
        $query = "UPDATE gamesearch set isCreated = 0 where username = '$username'";
        mysqli_query($db,$query);
   		 	header('location: game.php');
   		 } 
    ?>
    </body>
</html>

