<?php
	if (!isset($_COOKIE['last_visited_time'])) {
		echo "first time login."."<br/>";
	} else {
		echo "last login time: ".$_COOKIE['last_visited_time'];
	}
	setCookie('last_visited_time', date('Y-m-d H:i:s'), time() + 3600);
?>
