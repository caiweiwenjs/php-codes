<?php
	//From << PHP Objects Patterns and Practice >>
	class Person {
		public $name;

		public function __construct($name) {
			$this->name= $name;
		}
	}

	interface Module {
		public function execute();
	}
	
	class FtpModule implements Module {
		public function setHost($host) {
			echo "FtpModule::setHost() : $host <br/>";
		}

		public function setUser($user) {
			echo "FtpModule::setUser() : $user <br/>";
		} 

		public function execute() {
			// do some things
		}
	}
	
	class PersonModule implements Module {
		public function setPerson(Person $person) {
			echo "PersonModule::setPerson() : $person->name <br/>";
		}

		public function execute() {
			// do some things
		}
	}

	class ModuleRunner {
		private $configData = array(
				"FtpModule" => array( 
						"host" => "www.baidu.com",
						"user" => "cww"
					),
				"PersonModule" => array (
						"person" => "caiweiwen"
					)
				);
		private $modules = array();


		public function init() {
			$interface = new ReflectionClass('Module');
			foreach ($this->configData as $moduleName => $params) {
				$moduleClass = new ReflectionClass($moduleName);
				if (!$moduleClass->isSubclassOf($interface)) {
					throw new Exception("unknown module type: $moduleName");
				}
				$module = $moduleClass->newInstance();
				foreach ($moduleClass->getMethods() as $method) {
					$this->handleMethod($module, $method, $params);
				}
				array_push($this->modules, $module);
			}
		}

		private function handleMethod(Module $module, ReflectionMethod $method, $params) {
			$name = $method->getName();
			$args = $method->getParameters();
			
			if (count($args) != 1 || strtolower(substr($name, 0, 3)) != 'set') {
				return false;
			}

			$property = strtolower(substr($name, 3));
			if (!isset($params[$property])) {
				return false;
			}

			$arg_class = $args[0]->getClass();
			if (empty($arg_class)) {
				$method->invoke($module, $params[$property]);
			} else {
				$method->invoke($module, $arg_class->newInstance($params[$property]));
			}
		}
	}
	
	$test = new ModuleRunner();
	$test->init();
?>
