<?php

include_once("util.php");

function ptoRequestForm() {
	global $conn,$uid;
	
	$id = uniqueID();
	
	$html="
			<form role='form'>
				<div class='form-group'>
					<label>Start Date</label>
					<div class='input-group date'>
						<input type='text' class='form-control' id='".$id."datetimepicker1'/>
						<span class='input-group-addon'>
							<span class='glyphicon glyphicon-calendar'></span>
						</span>
					</div>
				</div>
				<div class='form-group'>
					<label>End Date</label>
					<div class='input-group date'>
						<input type='text' class='form-control' id='".$id."datetimepicker2'/>
						<span class='input-group-addon'>
							<span class='glyphicon glyphicon-calendar'></span>
						</span>
					</div>
				</div>
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

?>

