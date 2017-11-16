<?php
session_start();
//session_destroy();
	$username = "";
	$password = "";
	$colors = array("#FFFFFF", "#F59EA0");
	if(!isset($_SESSION['color'])){
		$_SESSION['color'] = "#5F9EA0";
		$_SESSION['color1'] = "#5F9EA0";
		$_SESSION['color2'] = "#5F9EA0";
		$_SESSION['color3'] = "#5F9EA0";
		$_SESSION['color4'] = "#5F9EA0";
		$_SESSION['color5'] = "#5F9EA0";
		$_SESSION['color6'] = "#5F9EA0";
		$_SESSION['color7'] = "#5F9EA0";
		$_SESSION['color8'] = "#5F9EA0";

	}
	if(!isset($_SESSION['count'])){
		$_SESSION['count'] = 0;
	}


	//$_SESSION['username'] = "";
	$errors = array();

	$db = mysqli_connect('localhost', 'root','','deliverable3');

	if(!$db){
		die('error');
	}

	if(isset($_POST['registers'])){
		echo "kys";
		$username = mysqli_real_escape_string($db,$_POST['username']);
		$password = mysqli_real_escape_string($db,$_POST['password']);

		if(empty($password)){
			array_push($errors,"Password is required");
		}

		if(empty($username)){
			array_push($errors,"Username is required");
		}


		//if there are no errors
		if(count($errors) == 0){
			$sql = "INSERT INTO gamesearch(accountID,username,password,isCreated,isFound,wins,loses,Draws) VALUES(0,'$username','$password',0,0,0,0,0)";
		    mysqli_query($db,$sql);
			//echo $result;
			$sqll = "INSERT INTO login(accountID,username,password) VALUES(0,'$username', '$password')";
			mysqli_query($db,$sqll);
			//echo $result;
			mysqli_close($db);
			echo "Hello world";
			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in!";
			header('location: index.php'); //redirect to homepage

		}
	}



	if(isset($_POST['login'])){
		echo "working";
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		echo $username;
		if(empty($password)){
			array_push($errors,"Password is required");
			//echo $username;
		}

		if(empty($username)){
			array_push($errors,"Username is required");
			//echo $password;
		}
		//echo "something";
		echo (count($errors));


		if(count($errors) == 0){
			//echo "workz";
			//$password = md5($password); // encrpt pword
			$query = "SELECT * FROM gamesearch WHERE username = '$username' AND password = '$password'";
			$result = mysqli_query($db,$query);
			if(mysqli_num_rows($result) == 1 ){
				echo "BLOOPIE";
				$_SESSION['username'] = $username;
				//echo $_SESSION['username'];
				$_SESSION['success'] = "You are logged in";
				 header('location: index.php');
			}
			else{ 
				array_push($errors,"wrong username or password");
			  echo "Boom";
			 // header('location: login.php');
			}	
		}
	}

	if (isset($_GET['logout'])){
		echo "kys";
		session_destroy();
		unset($_SESSION['username']);
		header('location: login.php');
	}

	if(isset($_POST['join-game'])){
		 $query = "SELECT * FROM gamesearch where isCreated = 1";
   		 $results = mysqli_query($db,$query);
   		 $_SESSION['serverturn'] = 1;
   		 if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 echo "hi";
   		 $cz = 1;
   		 $_SESSION['playerturn'] = $cz;
   		 $_SESSION['users'] = array();
   		 while($ri=mysqli_fetch_array($results)){
   		 	array_push($_SESSION['users'] ,$ri['username']);
   		 }
		header('location: lobby.php');
	}

	error_reporting(E_ALL ^ E_NOTICE); 


	if(isset($_POST['create-game'])){
		echo "working";
		header('location: waiting.php');
		echo $_SESSION['username'];
		//echo "banana";
		$var = $_SESSION['username'];
		echo $var;
		$vz = 1;
		$vx = 0;
		$_SESSION['serverturn'] = $vz;
		$_SESSION['playerturn'] = $vx;
		$query = "UPDATE gamesearch set isCreated =1 where username ='$var'";
		mysqli_query($db,$query);
	}
	if(isset($_POST['leaderboards'])){
		echo "working";
		header('location: leaderboards.php');
	}

	if(isset($_POST['restart']) && $_SESSION['isPlaying'] == 0){
		unset($_POST['board']);
		$_SESSION['color'] = "#5F9EA0";
		$_SESSION['color1'] = "#5F9EA0";
		$_SESSION['color2'] = "#5F9EA0";
		$_SESSION['color3'] = "#5F9EA0";
		$_SESSION['color4'] = "#5F9EA0";
		$_SESSION['color5'] = "#5F9EA0";
		$_SESSION['color6'] = "#5F9EA0";
		$_SESSION['color7'] = "#5F9EA0";
		$_SESSION['color8'] = "#5F9EA0";
		$_SESSION['isPlaying'] = 1;
		$var = $_SESSION['username'];
		$query = "UPDATE game set resetGame =1 where player1 ='$var' OR player2 = '$var' ";

		mysqli_query($db,$query);
		//header('location: index.php');
	}

	if(!function_exists('checkGame')){
function checkGame(){
	$db = mysqli_connect('localhost', 'root','','deliverable3');

	if($_SESSION['count'] ==9){
		echo "It's a draw!";
		$_SESSION['isPlaying'] = 0;
		$username = $_SESSION['username'];
		$query = "SELECT * from gamesearch where username = '$username'";
		$results = mysqli_query($db,$query);
		if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 //echo "hi";
   		 $ri=mysqli_fetch_array($results);
   		 $draws = (int)$ri['draws'];
   		 $draws = $draws+ 1;
   		 $queryz = "UPDATE gamesearch set draws = '$draws' where username = '$username'";
   		 mysqli_query($db,$queryz);

	}
	if($_SESSION['board'][0] == 1 && $_SESSION['board'][1] == 1 && $_SESSION['board'][2] ==1){
		echo "You've won!";
		$_SESSION['isPlaying'] = 0;
		$username = $_SESSION['username'];
		echo $username;
		$query = "SELECT * from gamesearch where username = '$username'";
		$results = mysqli_query($db,$query);
		//mysqli_query($db,$querys);
   		 if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 //echo "hi";
   		 $ri=mysqli_fetch_array($results);
   		 $wins = (int)$ri['wins'];
   		 $wins = $wins+ 1;
   		 $queryz = "UPDATE gamesearch set wins = '$wins' where username = '$username'";
   		 mysqli_query($db,$queryz);
		//session_unset();
	}
	if($_SESSION['board'][0] == 1 && $_SESSION['board'][4] == 1 && $_SESSION['board'][8] ==1){
		echo "You've won!";
		$_SESSION['isPlaying'] = 0;
		$username = $_SESSION['username'];
		echo $username;
		$query = "SELECT * from gamesearch where username = '$username'";
		$results = mysqli_query($db,$query);
		//mysqli_query($db,$querys);
   		 if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 //echo "hi";
   		 $ri=mysqli_fetch_array($results);
   		 $wins = (int)$ri['wins'];
   		 $wins = $wins+ 1;
   		 $queryz = "UPDATE gamesearch set wins = '$wins' where username = '$username'";
   		 mysqli_query($db,$queryz);
		//session_unset();
	}

	if($_SESSION['board'][0] == 1 && $_SESSION['board'][3] == 1 && $_SESSION['board'][6] ==1){
		echo "You've won!";
		$_SESSION['isPlaying'] = 0;
		$username = $_SESSION['username'];
		echo $username;
		$query = "SELECT * from gamesearch where username = '$username'";
		$results = mysqli_query($db,$query);
		//mysqli_query($db,$querys);
   		 if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 //echo "hi";
   		 $ri=mysqli_fetch_array($results);
   		 $wins = (int)$ri['wins'];
   		 $wins = $wins+ 1;
   		 $queryz = "UPDATE gamesearch set wins = '$wins' where username = '$username'";
   		 mysqli_query($db,$queryz);
		//session_unset();
	}

	if($_SESSION['board'][1] == 1 && $_SESSION['board'][4] == 1 && $_SESSION['board'][7] ==1){
		echo "You've won!";
		$_SESSION['isPlaying'] = 0;
		$username = $_SESSION['username'];
		echo $username;
		$query = "SELECT * from gamesearch where username = '$username'";
		$results = mysqli_query($db,$query);
		//mysqli_query($db,$querys);
   		 if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 //echo "hi";
   		 $ri=mysqli_fetch_array($results);
   		 $wins = (int)$ri['wins'];
   		 $wins = $wins+ 1;
   		 $queryz = "UPDATE gamesearch set wins = '$wins' where username = '$username'";
   		 mysqli_query($db,$queryz);
		//session_unset();
	}

	if($_SESSION['board'][2] == 1 && $_SESSION['board'][5] == 1 && $_SESSION['board'][8] ==1){
		echo "You've won!";
		$_SESSION['isPlaying'] = 0;
		$username = $_SESSION['username'];
		echo $username;
		$query = "SELECT * from gamesearch where username = '$username'";
		$results = mysqli_query($db,$query);
		//mysqli_query($db,$querys);
   		 if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 //echo "hi";
   		 $ri=mysqli_fetch_array($results);
   		 $wins = (int)$ri['wins'];
   		 $wins = $wins+ 1;
   		 $queryz = "UPDATE gamesearch set wins = '$wins' where username = '$username'";
   		 mysqli_query($db,$queryz);
		//session_unset();
	}

	if($_SESSION['board'][3] == 1 && $_SESSION['board'][4] == 1 && $_SESSION['board'][5] ==1){
		echo "You've won!";
		$_SESSION['isPlaying'] = 0;
		$username = $_SESSION['username'];
		echo $username;
		$query = "SELECT * from gamesearch where username = '$username'";
		$results = mysqli_query($db,$query);
		//mysqli_query($db,$querys);
   		 if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 //echo "hi";
   		 $ri=mysqli_fetch_array($results);
   		 $wins = (int)$ri['wins'];
   		 $wins = $wins+ 1;
   		 $queryz = "UPDATE gamesearch set wins = '$wins' where username = '$username'";
   		 mysqli_query($db,$queryz);
		//session_unset();
	}

	if($_SESSION['board'][6] == 1 && $_SESSION['board'][4] == 1 && $_SESSION['board'][2] ==1){
		echo "You've won!";
		$_SESSION['isPlaying'] = 0;
		$username = $_SESSION['username'];
		echo $username;
		$query = "SELECT * from gamesearch where username = '$username'";
		$results = mysqli_query($db,$query);
		// /mysqli_query($db,$querys);
   		 if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 //echo "hi";
   		 $ri=mysqli_fetch_array($results);
   		 $wins = (int)$ri['wins'];
   		 $wins = $wins+ 1;
   		 $queryz = "UPDATE gamesearch set wins = '$wins' where username = '$username'";
   		 mysqli_query($db,$queryz);
		//session_unset();
	}	

	if($_SESSION['board'][0] == 0 && $_SESSION['board'][1] == 0 && $_SESSION['board'][2] ==0){
		echo " Player two won!";
		$_SESSION['isPlaying'] = 0;
		echo $username;
		$username = $_SESSION['username'];
		$query = "SELECT * from gamesearch where username = '$username'";
		$results = mysqli_query($db,$query);
		//mysqli_query($db,$querys);
   		 if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 //echo "hi";
   		 $ri=mysqli_fetch_array($results);
   		 $loses = (int)$ri['loses'];
   		 $loses = $loses+ 1;
   		 $queryz = "UPDATE gamesearch set loses = '$loses' where username = '$username'";
   		 mysqli_query($db,$queryz);
		$username = $_SESSION['username'];
		$query = "SELECT * from gamesearch where username = '$username'";
		$results = mysqli_query($db,$query);
		//mysqli_query($db,$querys);
   		 if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 //echo "hi";
   		 $ri=mysqli_fetch_array($results);
   		 $loses = (int)$ri['loses'];
   		 $loses = $loses+ 1;
   		 $queryz = "UPDATE gamesearch set loses = '$loses' where username = '$username'";
   		 //mysqli_query($db,$queryz);
		//session_unset();
	}
	if($_SESSION['board'][0] == 0 && $_SESSION['board'][4] == 0 && $_SESSION['board'][8] ==0){
		echo "Player two won!";
		$_SESSION['isPlaying'] = 0;
		$username = $_SESSION['username'];
		echo $username;
		$query = "SELECT * from gamesearch where username = '$username'";
		$results = mysqli_query($db,$query);
		//mysqli_query($db,$querys);
   		 if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 //echo "hi";
   		 $ri=mysqli_fetch_array($results);
   		 $loses = (int)$ri['loses'];
   		 $loses = $loses+ 1;
   		 $queryz = "UPDATE gamesearch set loses = '$loses' where username = '$username'";
   		 //mysqli_query($db,$queryz);
		//session_unset();
	}

	if($_SESSION['board'][0] == 0 && $_SESSION['board'][3] == 0 && $_SESSION['board'][6] ==0){
		echo "Player two won!";
		$_SESSION['isPlaying'] = 0;
		$username = $_SESSION['username'];
		echo $username;
		$query = "SELECT * from gamesearch where username = '$username'";
		$results = mysqli_query($db,$query);
		//mysqli_query($db,$querys);
   		 if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 //echo "hi";
   		 $ri=mysqli_fetch_array($results);
   		 $loses = (int)$ri['loses'];
   		 $loses = $loses+ 1;
   		 $queryz = "UPDATE gamesearch set loses = '$loses' where username = '$username'";
   		 mysqli_query($db,$queryz);
		//session_unset();
	}

	if($_SESSION['board'][1] == 0 && $_SESSION['board'][4] == 0 && $_SESSION['board'][7] ==0){
		echo "Player two won!";
		$_SESSION['isPlaying'] = 0;
		$username = $_SESSION['username'];
		echo $username;
		$query = "SELECT * from gamesearch where username = '$username'";
		$results = mysqli_query($db,$query);
		//mysqli_query($db,$querys);
   		 if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 //echo "hi";
   		 $ri=mysqli_fetch_array($results);
   		 $loses = (int)$ri['loses'];
   		 $loses = $loses+ 1;
   		 $queryz = "UPDATE gamesearch set loses = '$loses' where username = '$username'";
   		 mysqli_query($db,$queryz);
		//session_unset();
	}

	if($_SESSION['board'][2] == 0 && $_SESSION['board'][5] == 0 && $_SESSION['board'][8] ==0){
		echo "Player two won!";
		$_SESSION['isPlaying'] = 0;
		$username = $_SESSION['username'];
		echo $username;
		$query = "SELECT * from gamesearch where username = '$username'";
		$results = mysqli_query($db,$query);
		//mysqli_query($db,$querys);
   		 if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 //echo "hi";
   		 $ri=mysqli_fetch_array($results);
   		 $loses = (int)$ri['loses'];
   		 $loses = $loses+ 1;
   		 $queryz = "UPDATE gamesearch set loses = '$loses' where username = '$username'";
   		 mysqli_query($db,$queryz);
		//session_unset();
	}

	if($_SESSION['board'][3] == 0 && $_SESSION['board'][4] == 0 && $_SESSION['board'][5] ==0){
		echo "Player two won!";
		$_SESSION['isPlaying'] = 0;
		$username = $_SESSION['username'];
		echo $username;
		$query = "SELECT * from gamesearch where username = '$username'";
		$results = mysqli_query($db,$query);
		//mysqli_query($db,$querys);
   		 if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 //echo "hi";
   		 $ri=mysqli_fetch_array($results);
   		 $loses = (int)$ri['loses'];
   		 $loses = $loses+ 1;
   		 $queryz = "UPDATE gamesearch set loses = '$loses' where username = '$username'";
   		 mysqli_query($db,$queryz);
		//session_unset();
	}

	if($_SESSION['board'][6] == 0 && $_SESSION['board'][4] == 0 && $_SESSION['board'][2] ==0){
		echo "Player two won!";
		$_SESSION['isPlaying'] = 0;
		$username = $_SESSION['username'];
		echo $username;
		$query = "SELECT * from gamesearch where username = '$username'";
		$results = mysqli_query($db,$query);
		//mysqli_query($db,$querys);
   		 if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 //echo "hi";
   		 $ri=mysqli_fetch_array($results);
   		 $loses = (int)$ri['loses'];
   		 $loses = $loses+ 1;
   		 $queryz = "UPDATE gamesearch set loses = '$loses' where username = '$username'";
   		 mysqli_query($db,$queryz);
		//session_unset();
	}	
}
}


	if(isset($_POST['update'])){
		$username = $_SESSION['username'];
		echo $_SESSION['count'];
		$query = "SELECT * from game where player1 = '$username' or player2 = '$username'";
		$querys = "UPDATE gamesearch set isFound = 0 where username = '$username'";
		$results = mysqli_query($db,$query);
		mysqli_query($db,$querys);
   		 if (!$results) { // add this check.
    		die('Invalid query: ' . mysql_error());
			}
   		 //echo "hi";
   		 $ri=mysqli_fetch_array($results);
   		 $player1 = $ri['player1'];
   		 //echo $player1. "   ";
   		 $player2 = $ri['player2'];
   		 //echo $player2. "   ";
   		 //echo $_SESSION['username']. "    ";
   		 if ($_SESSION['username'] != $player1){
   		 	$_SESSION['currentopponent'] = $player1;
   		 }
   		 if($_SESSION['username'] != $player2){
   		 	$_SESSION['currentopponent'] =$player2;
   		 }
   		// print_r($ri);
   		 $playermove = $ri['square'];
   		 $zz = $ri['playerMove'];
   		 echo $zz." ";
   		  $_SESSION['serverturn'] = (int)$zz;
   		 // /echo $playermove."spagethi";
   		 $_SESSION['playermove'] = $playermove;

   		 if($_SESSION['playermove'] ==  0){
   		 	if($_SESSION['board'][0] ==2){
   		 		$_SESSION['board'][0] = 0;
   		 		$_SESSION['color'] = "#000000";
   		 		$_SESSION['count'] = $_SESSION['count'] + 1;
   		 		checkGame();
   		 		//echo $_SESSION['board'][0];
   		 	}
   		 }

   		 if($_SESSION['playermove'] == 1){
   		 	if($_SESSION['board'][1] ==2){
   		 		$_SESSION['board'][1] = 0;
   		 		$_SESSION['color1'] = "#000000";
   		 		$_SESSION['count'] = $_SESSION['count'] + 1;
   		 		checkGame();
   		 		//echo $_SESSION['board'][1];
   		 	}
   		 }

   		 if($_SESSION['playermove'] == 2){
   		 	if($_SESSION['board'][2] ==2){
   		 		$_SESSION['board'][2] = 0;
   		 		$_SESSION['color2'] = "#000000";
   		 		$_SESSION['count'] = $_SESSION['count'] + 1;
   		 		checkGame();
   		 		//echo $_SESSION['board'][2];
   		 	}
   		 }

   		 if($_SESSION['playermove'] == 3){
   		 	if($_SESSION['board'][3] ==2){
   		 		$_SESSION['board'][3] = 0;
   		 		$_SESSION['color3'] = "#000000";
   		 		$_SESSION['count'] = $_SESSION['count'] + 1;
   		 		checkGame();
   		 		//echo $_SESSION['board'][3];
   		 	}
   		 }

   		 if($_SESSION['playermove'] == 4){
   		 	if($_SESSION['board'][4] ==2){
   		 		$_SESSION['board'][4] = 0;
   		 		$_SESSION['color4'] = "#000000";
   		 		$_SESSION['count'] = $_SESSION['count'] + 1;
   		 		checkGame();
   		 		// /echo $_SESSION['board'][4];
   		 	}
   		 }

   		 if($_SESSION['playermove'] == 5){
   		 	if($_SESSION['board'][5] ==2){
   		 		$_SESSION['board'][5] =0;
   		 		$_SESSION['color5'] = "#000000";
   		 		$_SESSION['count'] = $_SESSION['count'] + 1;
   		 		checkGame();
   		 		//echo $_SESSION['board'][5];
   		 	}
   		 }

   		 if($_SESSION['playermove'] == 6){
   		 	if($_SESSION['board'][6] ==2){
   		 		$_SESSION['board'][6] =0;
   		 		$_SESSION['color6'] = "#000000";
   		 		$_SESSION['count'] = $_SESSION['count'] + 1;
   		 		checkGame();
   		 		//echo $_SESSION['board'][6];
   		 	}
   		 }

   		 if($_SESSION['playermove'] == 7){
   		 	if($_SESSION['board'][7] ==2){
   		 		$_SESSION['board'][7] =0;
   		 		$_SESSION['color7'] = "#000000";
   		 		$_SESSION['count'] = $_SESSION['count'] + 1;
   		 		checkGame();
   		 		//echo $_SESSION['board'][7];
   		 	}
   		 }

   		 if($_SESSION['playermove'] == 8){
   		 	if($_SESSION['board'][8] ==2){
   		 		$_SESSION['board'][8] =0;
   		 		$_SESSION['color8'] = "#000000";
   		 		$_SESSION['count'] = $_SESSION['count'] + 1;
   		 		checkGame();
   		 		//echo $_SESSION['board'][8];
   		 	}
   		 }
   		 //$a = $_SESSION['serverturn'];
   		// echo $a;
   		 $b = $_SESSION['playerturn'];
   		 echo $b."pineapple";

	}


	if(isset($_POST['button1']) && $_SESSION['isPlaying'] == 1 && $_SESSION['playerturn'] == $_SESSION['serverturn']){
		$_SESSION['color'] = "#ff0000";
		$_SESSION['count'] = $_SESSION['count'] + 1;
		$var = $_SESSION['username'];
		echo $var;
		$query = "UPDATE game set square =0 where player1 ='$var' OR player2 ='$var'";
		mysqli_query($db,$query);
	}

	if(isset($_POST['button2']) && $_SESSION['isPlaying'] == 1 && $_SESSION['playerturn'] == $_SESSION['serverturn']){
		$_SESSION['color1'] = "#ff0000";
		$_SESSION['count'] = $_SESSION['count'] + 1;
	}

	if(isset($_POST['button3']) && $_SESSION['isPlaying'] == 1 && $_SESSION['playerturn'] == $_SESSION['serverturn']){
		$_SESSION['color2'] = "#ff0000";
		$_SESSION['count'] = $_SESSION['count'] + 1;
	}

	if(isset($_POST['button4']) && $_SESSION['isPlaying'] == 1 && $_SESSION['playerturn'] == $_SESSION['serverturn']){
		$_SESSION['color3'] = "#ff0000";
		$_SESSION['count'] = $_SESSION['count'] + 1;
	}

	if(isset($_POST['button5']) && $_SESSION['isPlaying'] == 1 && $_SESSION['playerturn'] == $_SESSION['serverturn']){
		$_SESSION['color4'] = "#ff0000";
		$_SESSION['count'] = $_SESSION['count'] + 1;
	}

	if(isset($_POST['button6']) && $_SESSION['isPlaying'] == 1 && $_SESSION['playerturn'] == $_SESSION['serverturn']){
		$_SESSION['color5'] = "#ff0000";
		$_SESSION['count'] = $_SESSION['count'] + 1;
	}

	if(isset($_POST['button7']) && $_SESSION['isPlaying'] == 1 && $_SESSION['playerturn'] == $_SESSION['serverturn']){
		$_SESSION['color6'] = "#ff0000";
		$_SESSION['count'] = $_SESSION['count'] + 1;
	}

	if(isset($_POST['button8']) && $_SESSION['isPlaying'] == 1 && $_SESSION['playerturn'] == $_SESSION['serverturn']){
		$_SESSION['color7'] = "#ff0000";
		$_SESSION['count'] = $_SESSION['count'] + 1;
	}

	if(isset($_POST['button9']) && $_SESSION['isPlaying'] == 1 && $_SESSION['playerturn'] == $_SESSION['serverturn']){
		$_SESSION['color8'] = "#ff0000";
		$_SESSION['count'] = $_SESSION['count'] + 1;
	}

	if(isset($_POST['search'])){
		 $maker = mysqli_real_escape_string($db,$_POST['selected_text']);
		 echo $maker;
		 echo $_SESSION['username'];
		 $var = $_SESSION['username'];
		 echo "";
		 $_query = "UPDATE gamesearch set isFound =1 where username ='$maker'";
		 mysqli_query($db,$_query);
		 $select = "SELECT isFound from gamesearch where username = '$maker'";
		 $insertplayer = "INSERT INTO game(player1,player2,square,resetGame,playerMove,winLose) VALUES('$var','$maker',9,0,1,-2)";
		header('location:game.php');
		mysqli_query($db,$select);
		mysqli_query($db,$insertplayer);
		 //sleep(2);
		 //$qu = "UPDATE gamesearch set isFound = 0 where username = '$maker'";
		//mysqli_query($db,$qu);
	}

?>
