<?php

include('util.php');
include('autocomplete.php');

$tid=get('tid');
if ($tid) {
	//$resultset=$conn->query("SELECT * FROM ((SELECT tid,MAX(id) AS id FROM tasks GROUP BY tid) AS t1 JOIN tasks AS t2 ON t1.id=t2.id) WHERE t2.tid=$tid");
	$resultset=$conn->query("SELECT * FROM ((SELECT * FROM tasks WHERE tid=$tid) AS t1 JOIN users AS t2 ON t1.owner=t2.id) ORDER BY t1.id DESC");
	if ($row=$resultset->fetch_assoc()) {
		echo "<h2>Edit Task $tid</h2><table border='1'>";
		echo "<tr><th>Task</th>
					<th>Description</th>
					<th>Job</th>
					<th>Due Date</th>
					<th>Days Open</th>
					<th>Owner</th>
					</tr>";
		

			$dueDate=date("n/j/y",$row['dueDate']);
			$daysOpen=ceil((time()-$row['openDate'])/(24*60*60));
			echo "<tr id='view'>
					<td><a href='task.php?tid=$row[tid]'>$row[tid]</a></td>
					<td><a href='task.php?tid=$row[tid]'>$row[description]</a></td>
					<td>$row[jid]</td>
					<td>$dueDate</td>
					<td>$daysOpen</td>
					<td>$row[user]</td>
					<td><span class='glyphicon glyphicon-pencil' onClick='document.getElementById(\"view\").style.display=\"none\";document.getElementById(\"edit\").style.display=\"table-row\";'>hiiiii</span></td>
				</tr>
				<tr id='edit' style='display:none'>
					<td>$row[tid]</td>
					<td><input type='text' value='$row[description]' name='description'></td>
					<td><input type='text' value='$row[jid]' name='jid'></td>
					<td><input type='text' value='$dueDate' name='dueDate'></td>
					<td>$daysOpen</td>
					<td>" . autoCompleteTextbox("users","value='$row[user]' name='owner'") . "</td>
				</tr>";
		echo "</table>";
		
		
		echo "<h2>Revision History</h2><table border='1'>";
		echo "<tr><th>Task</th>
						<th>Description</th>
						<th>Job</th>
						<th>Due Date</th>
						<th>Days Open</th>
						<th>Owner</th>
						</tr>";
		while ($row=$resultset->fetch_assoc()) {
				$dueDate=date("n/j/y",$row['dueDate']);
				$daysOpen=ceil((time()-$row['openDate'])/(24*60*60));
				echo "<tr>
						<td><a href='task.php?tid=$row[tid]'>$row[tid]</a></td>
						<td><a href='task.php?tid=$row[tid]'>$row[description]</a></td>
						<td>$row[jid]</td>
						<td>$dueDate</td>
						<td>$daysOpen</td>
						<td>$row[user]</td>
					</tr>";
		}
		echo "</table>";		
		
		
	}
}
?>
