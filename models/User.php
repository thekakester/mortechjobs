<?php
	class User {
		
		//See __get() and __set()
		private $data = array();
		
		public function __construct($uid) {
			$this->uid = $uid;
		}
		
		/**PHP magic method.
		* If it's not loaded, attempt to load it.
		* Finally, return whatever we have ready
		*/
		public function __get($property) {
			if (!isset($this->data[$property])) { $this->load($property); }
			return $this->data[$property];
		}
		
		public function __set($property,$value) {
			$this->data[$property] = $value;
		}
		
		//This method should contain a way to load each varaiable of this class
		private function load($property) {
			switch ($property) {
				case "fName":
				case "lName":
				case "title":
				case "manager":
					$this->loadDemographics();
				case "username":
				case "email":
					$this->loadUsername();
			}
		}
		
		private function loadDemographics() {
			global $conn;
			
			//Set defaults in case we can't load anything from the database
			$this->fName 	= "Error";
			$this->lName 	= "Error";
			$this->title 	= "Error";
			$this->manager 	= new User(1);
			
			
			$resultSet = $conn->query("SELECT * FROM demographics WHERE uid=$this->uid ORDER BY id DESC LIMIT 1");
			if ($row = $resultSet->fetch_assoc()) {
				$this->fName = $row['fName'];
				$this->lName = $row['lName'];
				$this->title = $row['title'];
				$this->manager = new User($row['manager']);
			}
		}
		
		private function loadUsername() {
			global $conn;
			$resultSet = $conn->query("SELECT user FROM users WHERE id=$this->uid LIMIT 1");
			if ($row = $resultSet->fetch_assoc()) {
				$this->username = $row['user'];
				$this->email = $this->username . "@mortechdesign.com";
			}
		}
	}
?>