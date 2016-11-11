<?php
	require_once('composition.php');

	class RegistrationMgr {
		function register(Lesson $lesson) {
			//deal with lesson

			//inform somebody
			$notifier = Notifier::getNotifier();

			$notifier->inform(" new lesson: cost ({$lesson->cost()})" );

		}
	}
	
	abstract class Notifier {
		static function getNotifier() {
			if (rand(1, 2) == 1) {
				return new MailNotifier();
			} else {
				return new TextNotifier();
			}
		}

		abstract function inform($message);
	}

	class MailNotifier extends Notifier {
		function inform($message) {
			print "MAIL notification: {$message} <br/>";
		}

	}

	class TextNotifier extends Notifier {
		function inform($message) {
			print "TEXT notification: {$message} <br/>";
		}
	}
	
	//test
	$lesson1 = new Seminar(new TimedCostStrategy(), 4);
	$lesson2 = new Lecture(new FixedCostStrategy(), 4);
	$mgr = new RegistrationMgr();
	$mgr->register($lesson1);
	$mgr->register($lesson2);
?>
