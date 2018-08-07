<?php

include_once("util.php");
include_once('sortyTable.php');

function jobList() {
	global $conn,$uid;
	$id = uniqueID();
	$resultset=$conn->query("SELECT * FROM jobs WHERE uid=$uid ORDER BY id DESC");	//Select the most recent jobs (most recent is when id is the biggest)
	$html = "<table id='$id' onload='makeSorty(this)' class='table table-bordered table-hover table-striped'>";
	$html .= "<tr><th>Year</th>
				<th>Category</th>
				<th>Job #</th>
				<th>Due Date</th>
				<th>Days Open</th>
				<th>Plant</th>
				<th>Description</th>
				<th>Project Manager</th>
				</tr>";
	while ($row=$resultset->fetch_assoc()){
		$dueDate=date("n/j/y",$row['dueDate']);
		$daysOpen=ceil((time()-$row['openDate'])/(24*60*60));
		$html .= "<tr>
				<td>$row[year]</td>
				<td>$row[category]</td>
				<td><a href='task.php?jid=$row[jid]'>$row[jid]</a></td>
				<td>$dueDate</td>
				<td>$daysOpen</td>
				<td>$row[plant]</td>
				<td><a href='task.php?jid=$row[jid]'>$row[description]</a></td>
				<td>$row[pm]</td>
			</tr>";
	}
	$html .= "</table>";
	$html .= "<script>$(document).ready(function(){ makeSorty(document.getElementById('$id')) }) </script>";
	return $html;
}

function allJobs() {
	global $conn,$uid;
	$id = uniqueID();
	$resultset=$conn->query("SELECT * FROM jobs ORDER BY id DESC");	//Select the most recent jobs (most recent is when id is the biggest)
	$html = "<table id='$id' onload='makeSorty(this)' class='table table-bordered table-hover table-striped'>";
	$html .= "<tr><th>Year</th>
				<th>Category</th>
				<th>Job #</th>
				<th>Due Date</th>
				<th>Days Open</th>
				<th>Plant</th>
				<th>Description</th>
				<th>Project Manager</th>
				</tr>";
	while ($row=$resultset->fetch_assoc()){
		$dueDate=date("n/j/y",$row['dueDate']);
		$daysOpen=ceil((time()-$row['openDate'])/(24*60*60));
		$html .= "<tr>
				<td>$row[year]</td>
				<td>$row[category]</td>
				<td><a href='task.php?jid=$row[jid]'>$row[jid]</a></td>
				<td>$dueDate</td>
				<td>$daysOpen</td>
				<td>$row[plant]</td>
				<td><a href='task.php?jid=$row[jid]'>$row[description]</a></td>
				<td>$row[pm]</td>
			</tr>";
	}
	$html .= "</table>";
	$html .= "<script>$(document).ready(function(){ makeSorty(document.getElementById('$id')) }) </script>";
	return $html;
}

?>