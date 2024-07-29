<?php
	require "../functions.php";

	$random_code = get_code();

	$SQL = "INSERT INTO `commands`(`os_id`, `command`) VALUES ('".$random_code."', '"."')";
	$req = mysqli_query($conn, $SQL);

	echo $random_code;
?>