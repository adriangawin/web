<?php

session_start();

if ( $_SESSION['username'] ) {
	echo "Witaj, jestes zalogowany jako ".$_SESSION['username']." !<br>";
	echo '<a href="logout.php"><button>Logout</button></a>';
}
else {
	die("Musisz byc zalogowany");
}
?>