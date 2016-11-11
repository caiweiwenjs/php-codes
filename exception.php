<?php
	class A {
		private $file;
		public function __construct($file) {
			$this->file = $file;
			if (!file_exists($file)) {
				throw new Exception("file '$file' does not exist");
			}	
		}
	}
	
	try {	
		$a = new A('abc.txt');
	} catch (Exception $e) {
		die($e->__toString());
	}
?>
