<?php
	class TestClass {
		public $foo;
	
		public function __construct($foo) {
			$this->foo = $foo;
		}
		
		public function __toString() {
			return $this->foo;	
		}


	};
	
	$class = new TestClass('hello');
	echo $class;
	
	function testArray($arr) {
		$arr[0] = 1;
	}
	$arr = array();
	$arr[0] = 2;
	testArray($arr);
	var_dump($arr);
?>
