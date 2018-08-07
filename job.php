<?php

include_once('util.php');
include_once('loggedin.php');
include_once('autocomplete.php');


include('top.php');
echo head("Job Details");
echo panel("Job Details",jobDetails());
echo panel("Revision History",jobRevisionHistory());
include('bottom.php');

function jobDetails() {
	global $conn;
	$jid=get('jid');
	$html = "";
	if ($jid) {
		$resultset=$conn->query("SELECT * FROM jobs");
		if ($row=$resultset->fetch_assoc()) {
			$html .= "<table class='table table-bordered table-hover table-striped'>
						<tr><th>Year</th>
						<th>Category</th>
						<th>Job #</th>
						<th>Description</th>
						<th>Due Date</th>
						<th>Days Open</th>
						<th>Release Date</th>
						<th>Project Manager</th>
						<th>Edit</th>
						</tr>";
			

				$dueDate=date("n/j/y",$row['dueDate']);
				$daysOpen=ceil((time()-$row['openDate'])/(24*60*60));
				$html .= "<tr id='view'>
						<td><a href='task.php?tid=$row[tid]'>$row[tid]</a></td>
						<td><a href='task.php?tid=$row[tid]'>$row[description]</a></td>
						<td>$row[jid]</td>
						<td>$dueDate</td>
						<td>$daysOpen</td>
						<td>$row[user]</td>
						<td><a href='#' onClick='document.getElementById(\"view\").style.display=\"none\";document.getElementById(\"edit\").style.display=\"table-row\";'><span class='glyphicon glyphicon-pencil'></span></a></td>
					</tr>
					<tr id='edit' style='display:none'>
						<td>$row[tid]</td>
						<td><input type='text' value='$row[description]' name='description'></td>
						<td><input type='text' value='$row[jid]' name='jid' size=3></td>
						<td><input type='text' value='$dueDate' name='dueDate'></td>
						<td>$daysOpen</td>
						<td>" . autoCompleteTextbox("users","value='$row[user]' name='owner'") . "</td>
						<td><a href='#'><span class='glyphicon glyphicon-ok'></span></a></td>
					</tr>";
			$html .= "</table>";
		}
	}
	return $html;
}
function jobRevisionHistory() {
	global $conn;
	$tid=get('tid');
	$html = "";
	if ($tid) {
		$resultset=$conn->query("SELECT * FROM ((SELECT * FROM tasks WHERE tid=$tid) AS t1 JOIN users AS t2 ON t1.owner=t2.id) ORDER BY t1.id DESC");
		$html .= "<table class='table table-bordered table-hover table-striped'><tr>
						<th>Task</th>
						<th>Description</th>
						<th>Job</th>
						<th>Due Date</th>
						<th>Days Open</th>
						<th>Owner</th>
					</tr>";
		while ($row=$resultset->fetch_assoc()) {
				$dueDate=date("n/j/y",$row['dueDate']);
				$daysOpen=ceil((time()-$row['openDate'])/(24*60*60));
				$html .= "<tr>
						<td><a href='task.php?tid=$row[tid]'>$row[tid]</a></td>
						<td><a href='task.php?tid=$row[tid]'>$row[description]</a></td>
						<td>$row[jid]</td>
						<td>$dueDate</td>
						<td>$daysOpen</td>
						<td>$row[user]</td>
					</tr>";
		}
		$html .= "</table>";		
		
		
	}
	return $html;
}

?>

