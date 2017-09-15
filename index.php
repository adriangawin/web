<?php
session_start();
if( $_SESSION['username'] ) {
	echo "<script>window.location = 'main.php'</script>";
	die(); 
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Rejestrator czasu pracy w firmie</title>
	<meta name="author" content="user" >
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styles/style.css">
</head>
<body>
 <form action="login.php" method="post">
	<div class="container" style="background-color:#f1f1f1">
		Logowanie	
	</div> 
   <div class="container">
    <label><b>Login</b></label>
    <input type="text" placeholder="tutaj twoj login" name="username" required>

    <label><b>Haslo</b></label>
    <input type="password" placeholder="tutaj haslo" name="password" required>

    <button type="submit">Login</button>
  </div>

  <div class="container" style="background-color:#f1f1f1">
  	 Nie masz jeszcze konta? 
    <a href="register.php"><button type="button">Załóż konto</button></a>
  </div>
</form>

</body>
</html>