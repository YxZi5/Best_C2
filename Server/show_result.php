<?php
	require "functions.php";

	if (!isset($_GET['id'])) {
		header('Location: app.php');
	}

	$system_id = $_GET['id'];
	
	$SQL = "SELECT result FROM commands WHERE os_id = ?";

	$stmt = $conn->prepare($SQL);

	$stmt->bind_param("s", $system_id);
	$stmt->execute();

	$sql_result = $stmt->get_result();
	$row = $sql_result->fetch_assoc();
	$result_value = $row['result'];

	$SQL2 = "UPDATE `commands` SET result = '' WHERE os_id = ?";
	$stmt = $conn->prepare($SQL2);

	$stmt->bind_param("s", $system_id);
	$stmt->execute();

	echo $result_value;
?>