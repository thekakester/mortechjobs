<?php

include_once("util.php");

function newTask() {
	global $conn,$uid;
	$id = uniqueID();
	
	$html="<script>
				$( function() {
					$( '#datepicker' ).datepicker();
				} );
			</script>
		<form role='form' method='post'>
			<div class='form-group'>
				<label>Select Job Number</label>
				<select class='form-control' name='jid'>";
	//<option>1</option>
	//<option>2</option>
	//<option>3</option>
	//<option>4</option>
	//<option>5</option>
	
	
	
	$html.= "</select>
						</div>
						<div class='form-group'>
							<label>Open Date</label>
							<div class='input-group date' id='datetimepicker1'>
								<input type='text' id='datepicker' name='openDate' />
								<span class='input-group-addon'>
									<span class='glyphicon glyphicon-calendar'></span>
								</span>
							</div>
						</div>
						<div class='form-group'>
							<label>Due Date</label>
							<div class='input-group date' id='datetimepicker1' name='dueDate' />
								<input type='text' class='form-control' />
								<span class='input-group-addon'>
									<span class='glyphicon glyphicon-calendar'></span>
								</span>
							</div>
						</div>
						<div class='form-group'>
                            <label>Task Description</label>
                            <textarea class='form-control' rows='3' name='description'></textarea>
                        </div>
						<div class='form-group'>
							<label>Select Task Owner</label>
							<select class='form-control'  name='owner'>
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>";
						//loop through all users
					$html.="</select>
						</div>
					</form>
				</div>
				<!-- /.col-lg-6 (nested) -->
			</div>
			<!-- /.row (nested) -->
		</div>
		<!-- /.panel-body -->
	</div>
	<!-- /.panel -->                
</html>";
return $html;

$jid=post('jid');
$openDate=post('openDate');
$dueDate=post('dueDate');
$description=post('description');
}

?>

