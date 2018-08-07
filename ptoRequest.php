<?php

include_once("util.php");
include_once("email.php");

function ptoRequestForm() {
	global $conn,$uid;
	
	$id = uniqueID();
	
	$html="
			<form role='form' method='post'>
				<div class='form-group'>
					<label>Start Date</label>
					<div class='input-group date'>
						<input type='text' class='form-control' name='startdate' id='".$id."datetimepicker1'/>
						<span class='input-group-addon'>
							<span class='glyphicon glyphicon-calendar'></span>
						</span>
					</div>
				</div>
				<div class='form-group'>
					<label>End Date</label>
					<div class='input-group date'>
						<input type='text' class='form-control' name='enddate' id='".$id."datetimepicker2'/>
						<span class='input-group-addon'>
							<span class='glyphicon glyphicon-calendar'></span>
						</span>
					</div>
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
	echo "Sending email";
	email("mdavis@mortechdesign.com","[AUTO] PTO Request","mdavis has requested PTO from $startdate to $enddate");
}

?>

