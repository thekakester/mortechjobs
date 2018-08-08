<?php

include_once("util.php");
include_once("email.php");
include_once("models/User.php");

function ptoRequestForm() {
	global $conn,$uid;
	
	$id = uniqueID();
	
	$user = new User($uid);
	$manager = $user->manager;
	
	$html="
			<form role='form' method='post'>
				<b>Requestor:</b> $user->fName $user->lName ($user->username)<br>
				<b>Manager:</b> $manager->fName $manager->lName ($manager->username)<br>
				<div id='multidate'></div>
				<input type='text' name='dates' id='dates'>
				<input type='submit' class='form-control'>
			</form>
			<script>
				$('#multidate').multiDatesPicker({
					onSelect: function() {updateDates();}
				});
				function updateDates() {
					$('#dates').val($('#multidate').multiDatesPicker('getDates'))
				}
			</script> 
			";
return $html;
}


$datesString = post("dates");
if ($datesString) {
	$dates = explode(",",$datesString);
	requestPTO($dates);
}

function requestPTO($dates) {
	global $uid,$conn;
	$user = new User($uid);
	$token = generateToken();
	
	$utc = time();
	
	//Surround this transaction in a try/catch in case
	//something fails
	try {
		$conn->begin_transaction();
		$resultSet = $conn->query("SELECT MAX(req_id) FROM pto_requests");
		$row = $resultSet->fetch_array();
		if (!$row) { return; }					//Early exit in case of crash
		$req_id = $row[0];
		if ($req_id == NULL) { $req_id = 1; }	//This returns 1 for the very first database entry ever
		//Start inserting our days
		foreach ($dates as $date) {
			$date_utc = beginningOfDayUTC(strtotime($date));
			$q = "INSERT INTO pto_requests (uid,req_id,utc,pto_utc,token) VALUES($uid,$req_id,$utc,$date_utc,'$token')";
			$conn->query($q);
		}
	
		$conn->commit();
	} catch (Exception $e) {
		$conn->rollback();
		throw $e;
	}
	
	$body = "$user->fName $user->lName ($user->username) has requested PTO from <br><a href='#'>Approve</a> - <a href='#'>Deny</a>";
	echo $body;
	//email("mdavis@mortechdesign.com","[AUTO] PTO Request for $user","");
}

?>

