<?php
	class Sea {
	}
	
	class EarthSea extends Sea {
	}

	class MarsSea extends Sea {
	}

	class Plains {
	}

	class EarthPlains extends Plains{
	}

	class MarsPlains extends Plains{
	}

	class Forest {
	}

	class EarthForest extends Forest {
	}

	class MarsForest extends Forest {
	}

	class TerrainFactory {
		private $sea;
		private $plains;
		private $forest;

		public function __construct(Sea $sea, Plains $plains, Forest $forest) {
			$this->sea = $sea;
			$this->plains = $plains;
			$this->forest = $forest;
		}

		public function getSea() {
			return clone $this->sea;
		}

		public function getPlains() {
			return clone $this->plains;
		}

		public function getForest() {
			return clone $this->forest;
		}
	
	}

	//test
	$terrainFactory = new TerrainFactory(new EarthSea(), new MarsPlains(), new MarsForest());
	var_dump($terrainFactory->getSea());
	echo "<br/>";
	var_dump($terrainFactory->getPlains());
	echo "<br/>";
	var_dump($terrainFactory->getForest());
?>
