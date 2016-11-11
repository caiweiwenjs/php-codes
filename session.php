<?php
	session_start();
	if (!isset($_SESSION['user_name'])) {
		$_SESSION['user_name'] = 'cww';		
	} else {
		echo "Get user name from session<br/>";
		echo "session id = ".session_id()."<br/>";
	}
	echo 'User name :'.$_SESSION['user_name'];
?>
