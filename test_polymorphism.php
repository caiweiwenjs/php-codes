<?php
	abstract class Base {
		abstract function func();
	}

	class A extends Base {
		private $name;

		public function func() {
			print "A::func() <br/>";
		}

		public function __construct($name) {
			$this->name = $name;
		}

		public function setName($name) {
			$this->name = $name;
		}

		public function getName() {
			return $this->name;
		}
	}

	//test
	function test(Base $a) {
		$a->func();
		print $a->getName() . "<br/>";
	}

	$a = new A('cww');
	test($a);
?>
