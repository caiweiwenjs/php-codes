<?php
	$mysql = new mysqli('localhost', 'root', 'cwwcww', 'php_test');

	if ($mysql->connect_error) {
		die('Connect Error (' . $mysql->connect_errno . ')' . $mysql->connect_error);
	}

	if ($result = $mysql->query("select * from user_info;")) {
		echo "Select returned ". $result->num_rows . " rows.<br/>";

		echo "<br/>";
		echo "Id\tName\tAge<br/>";
		while ($row = $result->fetch_row()) {
			echo "$row[0]\t$row[1]\t$row[2]<br/>";
		}

		$result->close();
	}

	$mysql->close();
?>
