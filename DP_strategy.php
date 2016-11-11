<?php
	abstract class Question {
		private $prompt;
		private $marker;

		public function __construct($prompt, Marker $marker) {
			$this->prompt = $prompt;
			$this->marker = $marker;
		}

		public function mark($response) {
			return $this->marker->mark($response);
		}
	}

	class TextQuestion extends Question {
	}

	class AVQuestion extends Question {
	}

	abstract class Marker {
		protected $test;

		public function __construct($test) {
			$this->test = $test;
		}

		abstract function mark($response);
	}

	class MarkLogicMarker extends Marker {
		private $engine;

		public function __construct($test) {
			parent::__construct($test);
			//$this->engine = new MarkParse($test);
		}
		public function mark($response) {
			//return $this->engine->evaluate($response);
			return true;
		}
	}

	class MatchMarker extends Marker {
		public function mark($response) {
			return ($this->test == $response);
		}
	}

	class RegexpMarker extends Marker {
		public function mark($response) {
			return (preg_match($this->test, $response));
		}
	}
	
	//test
	$markers = array( new RegexpMarker("/f.ve/"),
			new MatchMarker("five"),
			new MarkLogicMarker('$input equals "five"'));

	foreach ($markers as $marker) {
		print get_class($marker) . "<br/>";
		$question = new TextQuestion("how many beans make five", $marker);
		foreach (array("five", "four") as $response) {
			print "\tresponse: $response: ";
			if ($question->mark($response)) {
				print "well done<br/>";
			} else {
				print "never mind<br/>";
			}
		}
	}
?>

