<?php

include_once("util.php");

function taskList() {
	global $conn,$uid;
	$resultset=$conn->query("SELECT * FROM ((Select tid, MAX(id) as id from tasks GROUP BY tid) as t1 JOIN tasks as t2 ON t1.id = t2.id) WHERE owner=$uid");	//Select the most recent row for each tid (most recent is when id is the biggest)
	$html = "<table class='table table-bordered table-hover table-striped'>";
	$html .= "<tr><th>Task</th>
				<th>Description</th>
				<th>Job</th>
				<th>Due Date</th>
				<th>Days Open</th>
				</tr>";
	while ($row=$resultset->fetch_assoc()){
		$dueDate=date("n/j/y",$row['dueDate']);
		$daysOpen=ceil((time()-$row['openDate'])/(24*60*60));
		$html .= "<tr>
				<td><a href='task.php?tid=$row[tid]'>$row[tid]</a></td>
				<td><a href='task.php?tid=$row[tid]'>$row[description]</a></td>
				<td>$row[jid]</td>
				<td>$dueDate</td>
				<td>$daysOpen</td>
			</tr>";
	}
	$html .= "</table>";
	return $html;
}

?>