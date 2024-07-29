<?php
	require "../functions.php";


	if (!isset($_GET['com_id'])) {
		header('Location: ../app.php');
	}
	
	$computer_id = $_GET['com_id'];
	$ok = is_exists($computer_id);

	if ($ok != True) {
		header('Location: ../app.php');
	}
// 	echo '<p>Acctual controled device:</p>';
// 	echo '<p id="actual_value">'.$computer_id.'</p>';
// 	echo '<form method="get" action="index.php">
// 	command: <input type="text" name="command">
// 	<input type="hidden" name="com_id" value="'.$computer_id.'">
// 	<input type="submit" value="send">
// </form>';


	if (isset($_GET['com_id']) && isset($_GET['command'])) {
		$comm = $_GET['command'];
		$computer_id = $_GET['com_id'];

		// $SQL = "UPDATE `commands` SET `command`='".$comm."' WHERE `os_id`='".$computer_id."'";
		$SQL = "UPDATE `commands` SET `command` = ? WHERE `os_id` = ?";

		$stmt = $conn->prepare($SQL);

		if ($stmt == false) {
			die("Prepare failed");
		} 

		$stmt->bind_param("ss", $comm, $computer_id);
		$stmt->execute();

		if ($stmt->errno) {
			echo 'error';
		}

	}

?>