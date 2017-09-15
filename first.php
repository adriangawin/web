<?php

session_start();

$username = $_SESSION["username"];
$error = "";
$submit = $_POST["submit"];
$taryfa = $_POST["taryfa"];
$pompa = $_POST["pompa"];

$server = "sql.zeclowicz.nazwa.pl";
$usernamedb = "zeclowicz_2";
$password = "Gawinek18";
$database_name = "zeclowicz_2";

if ( !$username ) die("nie jesteś zalogowany");

if( $submit ) {
	$conn = mysql_connect($server, $usernamedb, $password);
	if ( !$conn ) $error = "connection faild";
	else {
		mysql_select_db($database_name, $conn);	
		$query = "select * from users where username='$username'";
		$result = mysql_query($query, $conn);
		if ( mysql_num_rows($result) == 0 ) die("nie znaleziono uzytkowniak");
		else {
			while($row = mysql_fetch_assoc($result)) {
				$isset = $row["isset"];			
			}	
			if($isset) {
				$error = "uzytkownik ma już ustawione parametry";			
			}	
			else {
				if($pompa){
					$query = "UPDATE users SET pomp = '1' WHERE username = '$username' ";
					$result = mysql_query($query, $conn);
					if( ! $result )	$error = "error update pompa".$result;					
				}	
				if( $taryfa == 1 ) {
					$query = "UPDATE users SET schedule = '1' where username = '$username'";	
					if ( ! mysql_query($query, $conn)) $error = "error update schedule";				
				}	
				elseif ( $taryfa == 2 ) {
					$query = "UPDATE users SET schedule = '2' where username = '$username'";	
					if ( ! mysql_query($query, $conn)) $error = "error update schedule";			
				}	
				$query = "UPDATE users SET isset = '1' where username = '$username'";
				if ( ! mysql_query($query, $conn) ) $error = "error update isset";
				else {
					// new tables
					echo "<script>window.location = 'http://zeclowicz.pl/energia/main.php'</script>";
				}		
			}
		}
	}
}
?>

<?php if( $_SESSION["username"]) : ?>

<html>
<head>
	<title>Energia</title>
	<meta name="author" content="user" >
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styles/style.css">
	
	<script type="text/javascript" src="jquery/jquery.js"></script>
</head>
<body>
<?php
	if ( $error ) echo $error;
?>
	<p style="padding:10px;">Witaj, <?php echo $_SESSION['username'] ?></p>
	<p>Wybierz odpowiednie ustawienia dla Twoich potrzeb</p>
	<form action="first.php" method="POST">
		<div class="container">
		Taryfa:<br><br>
		<input type="radio" name="taryfa" value="1" checked="true">stała taryfa<br><br>
		<input type="radio" name="taryfa" value="2"> dzienna / nocna<br><br>
		<input type="checkbox" name="pompa" value="pompa"> pompa ciepla<br><br>
		<button class="update_button" type="submit" name="submit" value="Zapisz">Zapisz</button>
		
		</div>
	</form>
</body>
</html>

<?php else : ?>
<?php echo "<script>window.location = 'http://zeclowicz.pl/energia'</script>"; ?>
<?php endif; ?>
