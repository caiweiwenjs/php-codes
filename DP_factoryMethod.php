<?php
	abstract class CommsManager {
		abstract function getHeaderText();
		abstract function getApptEncoder();
		abstract function getFooterText();
	}

	class MegaCommsManager extends CommsManager {
		public function getHeaderText() {
			return "MegaCal header";
		}

		public function getApptEncoder() {
			return new MegaApptEncoder();
		}

		public function getFooterText() {
			return "MegaCal footer";
		}
	}

	class BloggsCommsManager extends CommsManager {
		public function getHeaderText() {
			return "BloggsCal header";
		}

		public function getApptEncoder() {
			return new BloggsApptEncoder();
		}

		public function getFooterText() {
			return "BloggsCal footer";
		}
	}

	abstract class ApptEncoder {
		abstract function encode();
	}

	class MegaApptEncoder extends ApptEncoder {
		public function encode() {
			echo "Appointment data encoded in MagacCal format.<br/>";
		}
	}

	class BloggsApptEncoder extends ApptEncoder {
		public function encode() {
			echo "Appointment data encoded in BloggsCal format.<br/>";
		}
	}

	//test
	function test(CommsManager $commsManager) {
		$apptEncoder = $commsManager->getApptEncoder();
		print $commsManager->getHeaderText() . "<br/>";
		$apptEncoder->encode();	
		print $commsManager->getFooterText() . "<br/>";
	}
	
	test(new BloggsCommsManager());
	test(new MegaCommsManager());

?>
