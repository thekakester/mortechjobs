<?php

include_once("util.php");
include_once("models/User.php");
include_once("models/PTOCalendar.php");

function ptoCalendar() {
	$dayOfTheWeek = date('w');
	$startDayUTC = strtotime('-'.$dayOfTheWeek.' days');
	$startDayUTC = strtotime('today', $startDayUTC);	//Round to midnight
	$html = "<table border=1><tr>
	<th style='padding-left: 10px'>Sunday</th>
	<th style='padding-left: 10px'>Monday</th>
	<th style='padding-left: 10px'>Tuesday</th>
	<th style='padding-left: 10px'>Wednesday</th>
	<th style='padding-left: 10px'>Thursday</th>
	<th style='padding-left: 10px'>Friday</th>
	<th style='padding-left: 10px'>Saturday</th>
	</tr><tr>";
	for ($i = 0; $i < 14; $i++) {
		$currentDayUTC = $startDayUTC + ($i * 60*60*24);
		$day = new PTOCalendarDay($currentDayUTC);
		
		if ($i % 7 == 0 && $i > 0) {
			$html .= "</tr><tr>";
		}
		
		$backgroundColor = "#fff";
		if ($currentDayUTC == strtotime('today')) { 
			$backgroundColor="#ffff99";
		}
		
		$html .= "<td width=150 bgcolor='$backgroundColor' style='vertical-align: top; padding: 10px;'>";
		
		$html .= "<b>" . date("n/j/y",$currentDayUTC) . "</b><br><br>";
		foreach ($day->ptoRequests as $request) {
			$user = $request->user;
			$color = "#EA4335";	//Red
			if ($request->status == 1) { $color = "#34A853"; }	//Green
			$html .= "<font color='$color'>$user->fName $user->lName</font><br>";
		}
		$html .= "</td>";
	}
	$html .= "</tr></table>";

	
	return $html;
}

?>