<?php

session_start();

	$error = null;
	$submit = $_POST['submit'];
	$fullname = $_POST['fullname'];
	$username = $_POST['username'];
	
	$password = $_POST['password'];
	$repeatpassword = $_POST['repeatpassword'];
	$date = date("Y-m-d");
	
	if ( $submit ) {
		if ( strlen($fullname) > 30 ) {
			$error = "Za długie imie i nazwisko";
		} 
		elseif ( strlen($username) > 30 ) {
			$error = "Za długi login";
		} 
		elseif ( strlen($password) < 6 ) {
			$error = "Hasło musi być większe niż 6 liter";
		} 
		elseif ( strlen($password) > 15 ) {
			$error = "Hasło musi być krótsze niż 15 liter";
		} 
		else {
			if ( $password != $repeatpassword ) {
				$error = "Hasła rożnią się";			
			} 
			else {
				$password = md5($password);
				
				$connect = mysql_connect("sql.zeclowicz.nazwa.pl","zeclowicz_2","Gawinek18");
				if ( !$connect ) { $error = "Nie mozna połączyc z baza danych"; }
				else {
					mysql_select_db("zeclowicz_2");
					
					$query = mysql_query("
						select * from users where username='$username'
					");
					$count = mysql_num_rows($query);
					if ( $count != 0 ) {
						$error = "Login jest już zajęty";					
					}
					else {
						$query = mysql_query("
							insert into users	values ('','$fullname','$username','$password','$date',0,0,0)	
						");
						if ( !$query ) {
							$error = "Błąd wprowadzania danych";
						}
						else {
							$_SESSION['username'] = $username;
							echo "<script>window.location = 'http://zeclowicz.pl/energia/first.php'</script>";
						}
					}
				}
			}
		}
	}	
?>
<html>
<head>
	<title>Energia</title>
	<meta name="author" content="user" >
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styles/style.css">
</head>
<body>
 <form action="register.php" method="post">
	<div class="container" style="background-color:#f1f1f1">
		Rejestracja pracownika
	</div> 
   <?php if($error) { echo '
 	<div class="container" style="background-color:#f1f1f1; color:red;">
		'.$error.'
	</div> ';} ?>
  <div class="container">
	<label><b>Login/b></label>
	<input type="text" placeholder="tutaj twoj login" name="username" value="<?php echo $username; ?>" required>

	<label><b>Imie</b></label>
	<input type="text" placeholder="tutaj imie" name="firstname" value="<?php echo $fullname; ?>" required>  

	<label><b>Nazwisko</b></label>
	<input type="text" placeholder="tutaj nazwisko" name="lastname" value="<?php echo $fullname; ?>" required>  
	
	<label><b>Hasło</b></label>
	<input type="password" placeholder="tutaj haslo" name="password" required>
	
	<label><b>Potwierdz hasło</b></label>
	<input type="password" placeholder="tutaj haslo" name="repeatpassword" required>
	
	<button type="submit" name="submit" value="Register">Kontynuj</button>
  </div>

  <div class="container" style="background-color:#f1f1f1">
  	 Masz już konto?  
    <a href="index.php"><button type="button">Zaloguj się</button></a>
  </div>
</form>

</body>
</html>