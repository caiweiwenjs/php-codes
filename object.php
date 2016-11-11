<?php
	class SimpleClass {
		public $a;
		public function __construct($a) {
			$this->a = $a;
		}
	};
	$a = new SimpleClass(10);
	$b = new SimpleClass(10);
	var_dump($a);
	echo "<br/>";
	var_dump($b);
?>
