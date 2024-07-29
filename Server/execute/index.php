<?php
	require "../functions.php";

	if (!isset($_GET['id'])) {
		header('Location: ../app.php');
	}


	$id = $_GET['id'];
	$ok = is_exists($id);

	if ($ok != True) {
		header('Location: ../app.php');
	}

	$SQL = "SELECT command FROM commands WHERE os_id = ?";
	$stmt = $conn->prepare($SQL);

	$stmt->bind_param("s", $id);

	$stmt->execute();

	$res = $stmt->get_result();
	$row = $res->fetch_assoc();
	echo $row['command'];
?>