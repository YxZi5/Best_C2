<?php
	$conn = mysqli_connect('127.0.0.1', 'root', '', 'c2');
	if (!$conn) {
		echo 'error: connecting to databse';
	}

	function is_exists($id) {
		global $conn;

		$SQL = "SELECT * from `commands`";
		$res = mysqli_query($conn, $SQL);

		while ($row = mysqli_fetch_assoc($res)) {
			$os_id = $row['os_id'];

			if ($os_id == $id) {
				return True;
			}
		} 
		return False;
	}

	function remove_unactives() {
		global $conn;

		$SQL = "SELECT * FROM `commands`";
		$res = mysqli_query($conn, $SQL);

		while ($row = mysqli_fetch_assoc($res)) {
			$command_value = $row['command'];
			$id = $row['os_id'];

			if ($command_value != "") {
				$SQL2 = "DELETE FROM `commands` WHERE `os_id` = ?";
				$stmt = $conn->prepare($SQL2);
				$stmt->bind_param("s", $id);
				$stmt->execute();
			}

		}
	}

	function get_code() {
		$code = "os";

		for ($i = 0; $i <= 4; $i++) {
			$code .= strval(rand(0, 9));
		}

		return $code;
	}
?>