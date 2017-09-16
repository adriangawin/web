<?php
session_start();
$error = '';
$username = $_SESSION['username'];
$firstname = '';
$lastname = '';
$level;
$logged = 0;


if ( $username ) {
	$conn = mysql_connect('localhost', 'adrian', 'password');
	if ( ! $conn ) $error = 'cannot conntect to database';
	else {
		mysql_select_db('systemdb');
		$query = "select * from users where username='$username'";
		$result = mysql_query($query);
		if ( ! $result ) $error = 'error with query';
		else {
			$num = mysql_num_rows($result);
			if ( $num != 1 ) $error = 'count of users is not matching';
			else {
				while	( $row = mysql_fetch_assoc($result) ) {
					$firstname = $row['firstname'];	
					$lastname = $row['lastname'];
					if ( $_SESSION['username'] == $row['username']) {
						$logged = 1;
						$level = $row['level'];
					}		
					else 
						$logged = 0;
				}
			}
			
		}
	}
}
?>

<html>
<head>
	<title>Rejestracja czasu pracy</title>
	<meta name="author" content="adrian" >
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styles/style.css">
	
	<script type="text/javascript" src="jquery/jquery.js"></script>
</head>
<body>
<?php if ($error) { echo $error; die();} ?>
<?php if( $logged ): ?>



<div style="padding: 10px;">
	Witaj <?php echo $firstname; echo " "; echo $lastname ?> ! 
	<?php if ($level = 1) {echo "Jestes administratorem.";} else {echo "Jestes pracownikiem.";} ?>
</div>
<ul class="sidenav">
	<li><a onclick="click_main_page()">Strona głowna</a></li>
	<li><a onclick="click_update()">Aktualizuj liczniki</a></li>
	<li><a onclick="click_history()">Historia pomiarów</a></li>
	<!--li><a onclick="click_settings()">Ustawienia</a></li-->
	<li><a href="logout.php">Logout</a></li>
</ul>

<div id="main_page" class="content" style="display:block">
<div class="container">
	Pracownicy: <br>
</div>
</div>

<div id="update" class="content" style="display:none">
<?php if ( $schedule == 1 ) : ?>

  <form name="users" method="POST">
  <div class="container">
	KWh kupione<br>
	<input type="number" name="kwh_bought"><br>
	KWh sprzedane<br>
	<input type="number" name="kwh_sold"><br>
	<button class="update_button" type="button" value="Get" onclick="send_meters()">Wyślij</button>
  </div>
  </form>
<?php else : ?>

  <form name="update_form" method="POST">
	  <div class="container">
		KWh kupione - taryfa 1<br>
		<input type="number" name="kwh_bought_1" id="kwh_bought_1"><br>
		KWh kupione - taryfa 2<br>
		<input type="number" name="kwh_bought_2" id="kwh_bought_2"><br>
		KWh sprzedane<br>
		<input type="number" name="kwh_sold_1" id="kwh_sold_1"><br>
		<button class="update_button" type="button" value="Get" onclick="send_meters2()">Wyślij</button>
	  </div>
  </form>

<?php endif; ?>

  <form name="form_photo" method="POST">
  		<div class="container">
  			KWh wyprodukowane<br>
			<input type="number" name="kwh_produced"><br>
			<button class="update_button" type="button" value="Get" onclick="send_photo()">Wyślij</button>
  		</div>
  </form>

<?php if ( $pomp ) : ?>

	<form name="form_pomp" method="POST">
  		<div class="container">
  			KWh pompa ciepla<br>
			<input type="number" name="kwh_pump"><br>
			<button class="update_button" type="button" value="Get" onclick="send_pump()">Wyślij</button>
  		</div>
  </form>
  
<?php endif; ?>
</div>
<div id="history" class="content" style="display:none">
  <h2>History</h2>
  <p>Here is going to be your history.</p>
</div>

<div id="settings" class="content" style="display:none">
	<form method="POST">
		<div class="container">
		Taryfa:<br>
		<input type="radio" name="taryfa" value="1" checked="true">stała taryfa<br>
		<input type="radio" name="taryfa" value="2"> dzienna / nocna<br>
		<input type="checkbox" name="pompa" value="pompa"> pompa ciepla
		<button class="update_button" type="button">Zapisz</button>	
		
		</div>
	</form>
</div>

<div id="wait" style="display:none;width:140px;height:100px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;">
	<img src='http://www.w3schools.com/jquery/demo_wait.gif' style="width:64px;height:64px;margin-left:20px;"/>
	<br>Zapisywanie..
</div>

<script type="text/javascript">
function click_main_page() {
	document.getElementById('main_page').style.display = 'block';
	document.getElementById('update').style.display = 'none';
	document.getElementById('history').style.display = 'none';
	document.getElementById('settings').style.display = 'none';
}

function click_update() {
	document.getElementById('main_page').style.display = 'none';
	document.getElementById('update').style.display = 'block';
	document.getElementById('history').style.display = 'none';
	document.getElementById('settings').style.display = 'none';
}

function click_history() {
	document.getElementById('main_page').style.display = 'none';
	document.getElementById('update').style.display = 'none';
	document.getElementById('history').style.display = 'block';
	document.getElementById('settings').style.display = 'none';
}

function click_settings() {
	document.getElementById('main_page').style.display = 'none';
	document.getElementById('update').style.display = 'none';
	document.getElementById('history').style.display = 'none';
	document.getElementById('settings').style.display = 'block';
}
</script>
<script type="text/javascript">
	$('button2#meters').on('click', function(){
		var kwh_bought = $('input#kwh_bought')
	}); 

function send_meters() {
	var kwh_bought = $('input[name="kwh_bought"]').val();
	var kwh_sold = $('input[name="kwh_sold"]').val();
	//$("#wait").css("display", "block");
	$.post('data.php', {id: 'save_1',username:'<?php echo $_SESSION['username']; ?>', meter: kwh_bought, meter2: kwh_sold}, function(data){
		//$("#wait").css("display", "none");
		alert(data);
	});
}

function send_meters2() {
	var kwh_bought_1 = $('input[name="kwh_bought_1"]').val();
	var kwh_bought_2 = $('input[name="kwh_bought_2"]').val();
	var kwh_sold = $('input[name="kwh_sold_1"]').val();
	if ( kwh_bought_1 && kwh_bought_2 && kwh_sold ) {
		$.post('data.php', {id: 'save_2',username:'<?php echo $_SESSION['username']; ?>', meter: kwh_bought_1, meter2: kwh_bought_2, meter3: kwh_sold}, function(data){
			alert(data);
		});
	} else alert("wprowadz wszystkie dane");
}

function send_photo() {
	var kwh_produced = $('input[name="kwh_produced"]').val();
	if ( kwh_produced ) {
		$.post('data.php', { id: 'save_3',username:'<?php echo $_SESSION['username']; ?>', meter: kwh_produced}, function(data) {
			alert(data);
		});
	}
}
function send_pump() {
	var kwh_pump = $('input[name="kwh_pump"]').val();
	if ( kwh_pump ) {
		$.post('data.php', { id: 'save_4',username:'<?php echo $_SESSION['username']; ?>', meter: kwh_pump}, function(data) {
			alert(data);
		});
	}
}
</script>



<?php else: ?>
<?php echo "<script>window.location = 'index.php'</script>"; ?>
<?php endif; ?>

</body>
</html>
