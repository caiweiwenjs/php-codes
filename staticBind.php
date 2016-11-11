<?php
	abstract class DomainObject {
		public static function create() {
			return new static();
			//return new self(); //error!!
		}
	}
	
	class User extends DomainObject {
	}

	class Document extends DomainObject {
	}
	
	print_r(Document::create());
?>
