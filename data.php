<?php 
if ( $_POST['id'] == 'save_1' ||  $_POST['id'] == 'save_2' || $_POST['id'] == 'save_3' || $_POST['id'] == 'save_4' ) {
	$conn = mysqli_connect('sql.zeclowicz.nazwa.pl', 'zeclowicz_2', 'Gawinek18');
	if ( !$conn ) {
		echo 'cant connect to database';
	} 
	else {
		if ( $_POST['id'] == 'save_1' ) { // 1 meter
			$id = '';
			$username = $_POST['username'];
			$meter = $_POST['meter'];
			$meter2 = $_POST['meter2'];
			$query = "INSERT INTO zeclowicz_2.meters VALUES ('$id', '$username', NOW(), '$meter',0, '$meter2'); ";
			$result = mysqli_query($conn, $query);
			if ( ! $result ) echo 'error with insert data';
			else echo 'OK';
		}
		elseif ( $_POST['id'] == 'save_2' ) {  // 2 meters
			$id = '';
			$username = $_POST['username'];
			$meter = $_POST['meter'];
			$meter2 = $_POST['meter2'];
			$meter3 = $_POST['meter3'];
			$query = "INSERT INTO zeclowicz_2.meters VALUES ('$id', '$username', NOW(), '$meter','$meter2', '$meter3'); ";
			$result = mysqli_query($conn, $query);
			if ( ! $result ) echo 'error with insert data';
			else echo 'OK';
		}
		elseif ( $_POST['id'] == 'save_3' ) { // photo
			$id = '';
			$username = $_POST['username'];
			$meter = $_POST['meter'];
			$query = "INSERT INTO zeclowicz_2.photo VALUES ('$id', '$username', NOW(), '$meter'); ";
			$result = mysqli_query($conn, $query);
			if ( ! $result ) echo 'error with insert data';
			else echo 'OK';
		}
		elseif ( $_POST['id'] == 'save_4' ) { // pomp
			$id = '';
			$username = $_POST['username'];
			$meter = $_POST['meter'];
			$query = "INSERT INTO zeclowicz_2.pomp VALUES ('$id', '$username', NOW(), '$meter'); ";
			$result = mysqli_query($conn, $query);
			if ( ! $result ) echo 'error with insert data';
			else echo 'OK';;
		}
	}
}


else {

$conn = mysql_connect("sql.zeclowicz.nazwa.pl","zeclowicz_2","Gawinek18");

$name = mysql_real_escape_string($_POST['name2']);

$result = mysql_query("
	select * from zeclowicz_2.users where username='$name'
");

$num_rows = mysql_num_rows($result);

if ( $name == NULL ) {
	echo "Enter your name!";
}
else {
	if ( $num_rows == 0 ) { echo "Nic nie znaleziono"; }
	else {
		echo "Zadowoleni użytkownicy<br>";
		while($row = mysql_fetch_assoc($result)) {
			echo $row['fullname']."<br>";		
		}
	}
}

}
?>