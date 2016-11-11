<?php
	interface Observable {
		public function attach(Observer $observer);
		public function detach(Observer $observer);
		public function notify();
	}

	interface Observer {
		public function update(Observable $observable);
	}

	class Login implements Observable {
		const LOGIN_USER_UNKNOWN = 1;
		const LOGIN_WRONG_PASS = 2;
		const LOGIN_ACCESS = 3;
		private $status = array();
		private $observers;

		public function __construct() {
			$this->observers = array();
		}

		public function attach(Observer $observer) {
			$this->observers[] = $observer;
		}

		public function detach(Observer $observer) {
			$this->observers = array_udiff($this->observers, array($observer), 
					function ($a, $b) { return ($a == $b) ? 0 : 1;});
		}
		
		public function notify() {
			foreach ($this->observers as $observer) {
				$observer->update($this);
			}
		}

		public function handleLogin($user, $pass, $ip) {
			switch (rand(1, 3)) {
				case 1:
					$this->setStatus( self::LOGIN_ACCESS, $user, $ip);
					$ret = true;
					break;
				case 2:
					$this->setStatus(self::LOGIN_WRONG_PASS, $user, $ip);
					$ret = false;
					break;
				case 3:
					$this->setStatus(self::LOGIN_USER_UNKNOWN, $user, $ip);
					$ret = false;
					break;
			}
			$this->notify();
			return $ret;
		}

		private function setStatus($status, $user, $ip) {
			$this->status = array($status, $user, $ip);
		}

		public function getStatus() {
			return $this->status;
		}
	}

	abstract class LoginObserver implements Observer {
		private $login;

		public function __construct(Login $login) {
			$this->login = $login;
			$this->login->attach($this);
		}

		public function update(Observable $observable) {
			if ($observable == $this->login) {
				$this->doUpdate($observable);
			}
		}

		abstract function doUpdate(Login $login);
	}

	class SecurityMonitor extends LoginObserver {
		public function doUpdate(Login $login) {
			$status = $login->getStatus();
			if ($status[0] == Login::LOGIN_WRONG_PASS) {
				print __CLASS__ . ":\tsending mail to sysadmin<br/>";
			}
		}
	}

	class GeneralLogger extends LoginObserver {
		public function doUpdate(Login $login) {
			$status = $login->getStatus();
			print __CLASS__ . ":\tadd login data to log<br/>";
		}
	}

	class PartnershipTool extends LoginObserver {
		public function doUpdate(Login $login) {
			$status = $login->getStatus();
			print __CLASS__ . ":\tset cookie if IP matches a list<br/>";
		}
	}
	
	//test
	$login = new Login();
	new SecurityMonitor($login);
	new GeneralLogger($login);
	new PartnershipTool($login);
	$login->handleLogin("cww", "pass", "127.0.0.1");
?>

