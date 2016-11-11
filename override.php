<?php
	class A {
		public function __call($name, $arguments) {
			echo "there is not a function '$name($arguments)' in class A<br/>";
		}
		
		public function __set($name, $value) {
			echo "there is not a property '$name' in class A<br/>";
		}

		public function __get($name) {
			echo "there is not a property '$name' in class A<br/>";
		}

		public function fn() {
			echo "call A::fn()<br/>";
		}
	}
	
	$a = new A();

	$a->a = 10;
	$c = $a->b;
	$a->func('123');
?>
