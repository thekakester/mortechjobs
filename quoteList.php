<?php

include_once("util.php");
include_once('sortyTable.php');

function quoteList() {
	global $conn,$uid;
	$id = uniqueID();
	$resultset=$conn->query("SELECT * FROM quotes WHERE author=$uid ORDER BY id DESC");	//Select the most recent jobs (most recent is when id is the biggest)
	$html = "<table id='$id' onload='makeSorty(this)' class='table table-bordered table-hover table-striped'>";
	$html .= "<tr><th>Quote Number</th>
				<th>Customer</th>
				<th>Job #</th>
				<th>Date</th>
				</tr>";
	while ($row=$resultset->fetch_assoc()){
		$date=date("n/j/y",$row['date']);
		$daysOpen=ceil((time()-$row['openDate'])/(24*60*60));
		$html .= "<tr>
				<td>$row[quoteNum]</td>
				<td>$row[customer]</td>
				<td><a href='task.php?jid=$row[jid]'>$row[jid]</a></td>
				<td>$date</td>
			</tr>";
	}
	$html .= "</table>";
	$html .= "<script>$(document).ready(function(){ makeSorty(document.getElementById('$id')) }) </script>";
	return $html;
}

function allQuotes() {
	global $conn,$uid;
	$id = uniqueID();
	$resultset=$conn->query("SELECT * FROM quotes ORDER BY id DESC");	//Select the most recent jobs (most recent is when id is the biggest)
	$html = "<table id='$id' onload='makeSorty(this)' class='table table-bordered table-hover table-striped'>";
	$html .= "<tr><th>Quote Number</th>
				<th>Author</th>
				<th>Customer</th>
				<th>Job #</th>
				<th>Date</th>
				</tr>";
	while ($row=$resultset->fetch_assoc()){
		$dueDate=date("n/j/y",$row['dueDate']);
		$daysOpen=ceil((time()-$row['openDate'])/(24*60*60));
		$html .= "<tr>
				<td>$row[quoteNum]</td>
				<td>$row[author]</td>
				<td>$row[customer]</td>
				<td><a href='task.php?jid=$row[jid]'>$row[jid]</a></td>
				<td>$date</td>
			</tr>";
	}
	$html .= "</table>";
	$html .= "<script>$(document).ready(function(){ makeSorty(document.getElementById('$id')) }) </script>";
	return $html;
}

?>