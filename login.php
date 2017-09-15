<?php

session_start();

$username = $_POST['username'];
$password = $_POST['password'];
if ( $username && $password ) {
	$server = 'localhost';
	$db_username = 'adrian';
	$db_password = 'sandra34';
	$database_name = 'systemdb';
	$connect = mysql_connect($server, $db_username, $db_password) or die("could not connect");
	echo "connected<br>";
	mysql_select_db($database_name, $connect) or die("couldn't select");
	echo "selected<br>";
	
	$query = mysql_query("select * from users where username='$username'", $connect) or die("error selecting users");
	$numrows = mysql_num_rows($query);
	if ( $numrows != 0 ) {
		while ( $row = mysql_fetch_assoc($query)) {
			$dbusername = $row['username'];
			$dbpassword = $row['password'];		
		}
		if ( $username == $dbusername && md5($password) == $dbpassword ) {
			echo 'You are IN Click <a href="member.php">here</a> to enter the secret part';
			$_SESSION['username'] = $dbusername;
			echo "<script>window.location = 'main.php'</script>";
		}
		else 
			echo 'incorrect password!';
	}
	else 
		die("That user doesn't exist!");
	
	echo $numrows;
}
else 
	echo "<script>window.location = 'index.php'</script>";
?>