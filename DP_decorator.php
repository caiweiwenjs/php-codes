<?php
	abstract class Tile {
		abstract function getWealthFactor();
	}

	class Plains extends Tile {
		private $wealthFactor = 4;
		
		public function getWealthFactor() {
			return $this->wealthFactor;
		}
	}

	abstract class TileDecorator extends Tile {
		protected $tile;

		public function __construct(Tile $tile) {
			$this->tile = $tile;
		}
	}

	class DiamondDecorator extends TileDecorator {
		public function getWealthFactor() {
			return $this->tile->getWealthFactor() * 4;
		}
	}

	class PollutedDecorator extends TileDecorator {
		public function getWealthFactor() {
			return $this->tile->getWealthFactor() - 2;
		}
	}

	//test
	$tile = new Plains();
	print "Plains' wealth factor: {$tile->getWealthFactor()}.<br/>";

	$tile = new DiamondDecorator(new Plains());
	print "Diamond plains' wealth factor: {$tile->getWealthFactor()}.<br/>";

	$tile = new PollutedDecorator(new Plains());
	print "Polluted plains' wealth factor: {$tile->getWealthFactor()}.<br/>";

	$tile = new PollutedDecorator(new DiamondDecorator(new Plains()));
	print "Polluted and diamond plains' wealth factor: {$tile->getWealthFactor()}.<br/>";
?>

