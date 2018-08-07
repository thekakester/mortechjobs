<?php
	class PTOCalendarDay {
		public $utc;
		public $ptoRequests = array();
		
		public function __construct($utc) {
			global $conn;
			$this->utc = $utc;
			
			//Get all the data for this day
			$resultSet = $conn->query("SELECT id FROM pto WHERE utc_start <= $utc AND utc_end >= $utc");
			while ($row = $resultSet->fetch_assoc()) {
				$request = new PTORequest($row['id']);
				
				//Add all non-rejected tasks
				if ($request->status != 2) { $this->ptoRequests[] = $request;}
			}
		}
	}
	
	class PTORequest {
		public $id;
		public $user;
		public $status = 0;
		
		public function __construct($ptoID) {
			global $conn;
			
			$this->id = $ptoID;
			
			//Get the userID for this ptoID
			$resultSet = $conn->query("SELECT uid FROM pto WHERE id=$this->id LIMIT 1");
			if ($row = $resultSet->fetch_assoc()) {
				$this->user = new User($row['uid']);
			}
			
			//Get the status for this ptoID
			$resultSet = $conn->query("SELECT status FROM pto_statuses WHERE pto_id=$this->id ORDER BY id DESC LIMIT 1");
			if ($row = $resultSet->fetch_assoc()) {
				$this->status = $row['status'];
			}
		}
	}
?>