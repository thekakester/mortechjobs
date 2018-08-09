<?php

include_once("util.php");
include_once("email.php");
include_once("models/User.php");

function ptoRequestForm() {
	global $conn,$uid;
	
	if (!$uid) {
		$html = "You must <a href='login.php'>log in</a> to request PTO";
		return $html;
	}
	
	$id = uniqueID();
	
	$user = new User($uid);
	$manager = $user->manager;
	$ptoTotals = getPTOTotals($uid,time());
	$total = $ptoTotals[0] + $ptoTotals[1];
	$remaining = 10-$total;
	if ($remaining < 0) { $remaining = 0; }	//Chart breaks with negative numbers
	
	$html="
			<div class='col-lg-4 col-md-6'>
				<form role='form' method='post'>
					<b>Requestor:</b> $user->fName $user->lName ($user->username)<br>
					<b>Manager:</b> $manager->fName $manager->lName ($manager->username)<br><br>
					<div id='multidate'></div>
					<input type='hidden' name='dates' id='dates'>
					<input type='submit' class='btn btn-primary'>
				</form>
			</div>
			<div class='col-lg-3 col-md-5'>
				<table class='table'><tr><th colspan=2>$user->fName's PTO totals this year</th></tr>
				<tr><th>Approved:</th><td>$ptoTotals[1]</td></tr>
				<tr><th>Pending:</th><td>$ptoTotals[0]</td></tr>
				<tr><th>Total Used:</th><td>$total/10</td></tr></table>
				
				<div id='numDays'></div>
			</div>
			<div class='col-lg-5 col-md-1'>
				<div id='morris-donut-chart'></div>
			</div>
			<script>
				$('#multidate').multiDatesPicker({
					onSelect: function() {updateDates();}
				});
				function updateDates() {
					var dateString = $('#multidate').multiDatesPicker('getDates');
					$('#dates').val(dateString);
					$('#numDays').html(countDates(dateString) + ' day(s) selected');
				}
				function countDates(dateString) {
					dateString += '';	//Make sure it's a string
					if (dateString.length == 0) { return 0; }
					//CSV separated.  Count the ','s and add 1
					return dateString.split(',').length;
				}
				$(function() {
					Morris.Donut({
						element: 'morris-donut-chart',
						data: [{
							label: 'Days Remaining',
							value: $remaining
						}, {
							label: 'Pending Approval',
							value: $ptoTotals[0]
						}, {
							label: 'Approved Days',
							value: $ptoTotals[1]
						}],
						resize: true
					});
				});
			</script> 
			";
return $html;
}

//POSTBACK FOR REQUESTING
$datesString = post("dates");
if ($datesString) {
	$dates = explode(",",$datesString);
	requestPTO($dates);
}

//POSTBACK (GET) FOR APPROVING
$token = get("token");
$action = get("action");
$req_id = get("reqid");
if ($token && $action && $req_id) {
	applyAction($token,$req_id,$action);
}

function requestPTO($dates) {
	global $uid,$conn;
	$token = generateToken();
	
	$utc = time();
	
	$successfulDates = array();	//Store dates that successfully convert
	
	//Surround this transaction in a try/catch in case
	//something fails
	try {
		$conn->begin_transaction();
		$resultSet = $conn->query("SELECT MAX(req_id) FROM pto_requests");
		$row = $resultSet->fetch_array();
		if (!$row) { return; }					//Early exit in case of crash
		$req_id = $row[0];
		if ($req_id == NULL) { $req_id = 0; }	//This returns 0 for the very first database entry ever
		$req_id += 1;
		//Start inserting our days
		foreach ($dates as $date) {
			$date_utc = beginningOfDayUTC(strtotime($date));
			if ($date_utc == 0) { continue; }	//Skip if it failed to convert to a time
			$successfulDates[] = $date_utc;
			$q = "INSERT INTO pto_requests (uid,req_id,utc,pto_utc,token) VALUES($uid,$req_id,$utc,$date_utc,'$token')";
			$conn->query($q);
		}
	
		$conn->commit();
	} catch (Exception $e) {
		$conn->rollback();
		throw $e;
	}
	
	sendPTOEmail($successfulDates,$token,$req_id);
}

function sendPTOEmail($dates,$token,$req_id) {
	global $uid,$server_ip;
	$user = new User($uid);
	$manager = $user->manager;
	sort($dates);	//Sort increasing order
	$count = count($dates);
	
	if ($count == 0) { return; }
	
	$body = "$user->fName $user->lName ($user->username) has requested <b>$count</b> PTO day(s):<br><ul>";
	foreach ($dates as $utc) {
		$humanDate = date("n/j/y",$utc);
		$body .= "<li>$humanDate</li>";
	}
	$body .= "</ul><br><br>";

	//Print the count of used days
	$ptoTotals = getPTOTotals($uid,time());
	$total = $ptoTotals[0] + $ptoTotals[1];
	$body .= "<table border=1><tr><th colspan=2>$user->fName's PTO totals this year</th></tr>
	<tr><th>Approved:</th><td>$ptoTotals[1]</td></tr>
	<tr><th>Pending:</th><td>$ptoTotals[0]</td></tr>
	<tr><th>Total Used:</th><td>$total/10</td></tr></table><br><br>";
	
	//Approve and Deny Buttons EA4335
	$body .= "<table border=0>
	<tr><td width=100 height=50>
		<a href='$server_ip/pto.php?token=$token&reqid=$req_id&action=1' style='text-decoration: none'><div style='text-align:center; background-color: #34A853; color: #fff;'>Approve</div></a>
	</td><td width=100 height=50>
		<a href='$server_ip/pto.php?token=$token&reqid=$req_id&action=2' style='text-decoration: none'><div style='text-align:center; background-color: #EA4335; color: #fff;'>Deny</div></a>
	</td></tr></table>
	(Note: You must be at mortech for these links to work)<br><br>";
	
	
	//Print a calendar of dates
	$body .= "<hr><br><table border=1><tr>
	<th width=75>Sun</th>
	<th width=75>Mon</th>
	<th width=75>Tues</th>
	<th width=75>Wed</th>
	<th width=75>Thur</th>
	<th width=75>Fri</th>
	<th width=75>Sat</th></tr>";
	$dayOfTheWeek = date('w',$dates[0]);
	$startUTC = strtotime('-'.$dayOfTheWeek.' days',$dates[0]);
	
	$dateIndex = 0;
	$currentDay = $startUTC;
	while ($dateIndex < $count) {
		//Print 1 week at a time
		$body .= "<tr>";
		for ($i = 0; $i < 7; $i++) {
			$humanDate = date("n/j/y",$currentDay);
			$text = $humanDate;
			$color = "#fff";
			if ($dateIndex < $count && $dates[$dateIndex] <= $currentDay) {
				$color = "#ff0";
				$text .= "<br><br>Full Day";
				$dateIndex++;
			}
			$body .= "<td height=75 style='background-color:$color; vertical-align:top'>$text</td>";
			$currentDay += (24*60*60);
		}
		$body .= "</tr>";
	}
	$body .= "</table>";
	
	//echo $body;
	email($manager->email,"[AUTO] PTO Request for $user->fName $user->lName",$body);
}

function applyAction($token,$req_id,$action) {
	global $conn;
	
	//First, verify that we have the right token for the req_id for security reasons
	$resultSet = $conn->query("SELECT uid FROM pto_requests WHERE req_id=$req_id AND token='$token' LIMIT 1");
	$row = $resultSet->fetch_array();
	if (!$row) { echo "INVALID TOKEN"; return; }
	
	$user = new USER($row[0]);
	$manager = $user->manager;
	$utc = time();
	
	//Now, we can approve or deny the request
	$conn->query("INSERT INTO pto_statuses (req_id,uid,utc,status) VALUES($req_id,$manager->uid,$utc,$action)");
	$message = $action == 1 ? "PTO Approved successfully" : "PTO Denied Successfully";
	echo "<script>alert('$message')</script>";
}

//Pass in time() for $now to get this year.
//Pass in any other timestamp to get the report for that year (timestamp can be any time throughout that year.  EG 6/10/18 will result in 1/1/18-12/31/18)
function getPTOTotals($uid,$now) {
	global $conn;
	
	//Get UTC of Jan 1st at midnight of this year
	$beginningOfToday = strtotime("today");
	$daysThisYear = date("z");	//0-365
	$beginningOfYear = strToTime("-$daysThisYear days",$beginningOfToday);
	$endOfYear = strToTime("+1 year",$beginningOfYear);
	
	$ptoTotals = [0,0,0];	//Pending, Approved, Denied
	$resultSet = $conn->query("SELECT COUNT(req_id),req_id FROM pto_requests WHERE uid=2 AND pto_utc >= $beginningOfYear AND pto_utc < $endOfYear GROUP BY req_id");
	while ($row = $resultSet->fetch_array()) {
		$count = $row[0];
		$req_id = $row[1];
		$status = 0;		//0 means pending/undecided
		
		//Check the status of this
		$statusResultSet = $conn->query("SELECT status FROM pto_statuses WHERE req_id=$req_id ORDER BY id LIMIT 1");
		if ($statusRow = $statusResultSet->fetch_assoc()) {
			$status = $statusRow['status'];
		}
		
		$ptoTotals[$status] += $count;
	}
	
	return $ptoTotals;
}

?>

