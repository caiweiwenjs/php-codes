<?php
	function fun($p1, $p2) {
		echo 'In function fun:'.'parameter1 = '.$p1.';parameter2 = '.$p2.";<br/>";
	}		
	
	call_user_func('fun', 'para1', 'para2');
?>
