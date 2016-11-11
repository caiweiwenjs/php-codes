<?php
	abstract class CostStrategy {
		abstract function cost(Lesson $lesson);
		abstract function chargeType();
	}

	class Lesson {
		private $costStrategy;
		private $duration;

		public function __construct(CostStrategy $costStrategy, $duration) {
			$this->costStrategy = $costStrategy;
			$this->duration = $duration;
		}

		public function cost() {
			return $this->costStrategy->cost($this);
		}

		public function chargeType() {
			return $this->costStrategy->chargeType();
		}

		public function getDuration() {
			return $this->duration;
		}
	}
	
	class Lecture extends Lesson {
		public function __construct(CostStrategy $costStrategy, $duration) {
			parent::__construct($costStrategy, $duration);
		}
	}

	class Seminar extends Lesson {
		public function __construct(CostStrategy $costStrategy, $duration) {
			parent::__construct($costStrategy, $duration);
		}
	}


	class FixedCostStrategy extends CostStrategy {
		public function cost(Lesson $lesson) {
			return 10;
		}

		public function chargeType() {
			return 'fixed rate';
		}
	}

	class TimedCostStrategy extends CostStrategy {
		public function cost(Lesson $lesson) {
			return ($lesson->getDuration() * 5);
		}

		public function chargeType() {
			return 'hourly rate';
		}
	}

	//test
	$lessons[] = new Seminar(new TimedCostStrategy(), 4);
	$lessons[] = new Lecture(new FixedCostStrategy(), 4);

	foreach ($lessons as $lesson) {
		print "lesson charge {$lesson->cost()}. ";
		print "charge type: {$lesson->chargeType()} <br/>";
	}
?>

