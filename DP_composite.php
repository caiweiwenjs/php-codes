<?php
	abstract class Unit {
		abstract function bombardStrength();

		public function getComposite() {
			return NULL;
		}
	}

	abstract class CompositeUnit extends Unit {
		private $units = array();

		public function getCompostion() {
			return $this;
		}

		public function addUnit(Unit $unit) {
			if (!in_array($unit, $this->units, true)) {
				$this->units[] = $unit;
			}
		}
		
		public function removeUnit(Unit $unit) {
			$this->units = array_udiff($this->units, array($unit), function ($a, $b) { return ($a === $b) ? 0 : 1;});
		}

		public function bombardStrength() {
			$res = 0;
			foreach ($this->units as $unit) {
				$res += $unit->bombardStrength();
			}
			return $res;
		}
	}

	class Archer extends Unit {
		public function bombardStrength() {
			return 4;
		}
	}
	
	class LaserCannon extends Unit {
		public function bombardStrength() {
			return 44;
		}
	}
	
	class TroopCarrier extends CompositeUnit {
	}

	class Army extends CompositeUnit {
	}

	//test
	$main_army = new Army();

	$main_army->addUnit(new Archer());
	$main_army->addUnit(new LaserCannon());

	$sub_army = new Army();

	$sub_army->addUnit(new Archer());
	$sub_army->addUnit(new Archer());
	$sub_army->addUnit(new Archer());

	$main_army->addUnit($sub_army);

	print "attacking with strength: {$main_army->bombardStrength()}.<br/>";
?>
