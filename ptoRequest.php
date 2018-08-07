<?php

include_once("util.php");
include_once("email.php");
include_once("models/User.php");

function ptoRequestForm() {
	global $conn,$uid;
	
	$id = uniqueID();
	
	$user = new User($uid);
	$manager = $user->manager;
	
	//Get details about the user
	$conn->query("SELECT * FROM users WHERE id=$uid LIMIT 1");
	
	$html="
			<form role='form' method='post'>
				<label>Requestor: $user->fName $user->lName ($user->username)</label><br>
				<label>Manager: $manager->fName $manager->lName ($manager->username)</label><br>
				<label>Start Date</label>
				<div class='input-group date'>
					<input type='text' class='form-control' name='startdate' id='".$id."datetimepicker1' autocomplete='off'/>
					<span class='input-group-addon'>
						<span class='glyphicon glyphicon-calendar'></span>
					</span>
				</div>
				<label>End Date</label>
				<div class='input-group date'>
					<input type='text' class='form-control' name='enddate' id='".$id."datetimepicker2' autocomplete='off'/>
					<span class='input-group-addon'>
						<span class='glyphicon glyphicon-calendar'></span>
					</span>
				</div>
				<input type='submit' class='form-control'>
			</form>
			<script>
				$( function() {
					$( '#".$id."datetimepicker1' ).datepicker();
					$( '#".$id."datetimepicker2' ).datepicker();
				} );
			</script> 
			";
return $html;
}


$startdate = post("startdate");
$enddate = post("enddate");
if ($startdate && $enddate) {
	$user = new User($uid);
	$token = generateToken();
	$body = "$user->fName $user->lName ($user->username) has requested PTO from $startdate to $enddate<br><a href='#'>Approve</a> - <a href='#'>Deny</a>";
	echo $body;
	$utc = time();
	$utc_start = strtotime($startdate);
	$utc_end = strtotime($enddate);
	
	$query = "INSERT INTO pto (uid,utc,utc_start,utc_end,token) VALUES($uid,$utc,$utc_start,$utc_end,'$token')";
	$conn->query($query);
	echo $query;
	//email("mdavis@mortechdesign.com","[AUTO] PTO Request for $user","");
}

?>

