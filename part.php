<?php

include_once('util.php');
include_once('loggedin.php');
include_once('autocomplete.php');
include_once('partList.php');


include('top.php');
echo head("Part Details");
echo panel("Part Details",partDetails());
include('bottom.php');

function partDetails() {
	global $conn;
	$pid=get('pid');
	$html = "";
	if ($pid) {
		//$resultset=$conn->query("SELECT * FROM parts WHERE id=$pid as t1 LEFT JOIN part_categories as t2 ON t1.category = t2.id");
		$resultset=$conn->query("SELECT * FROM parts WHERE id=$pid");
		if ($row=$resultset->fetch_assoc()) {
			//Part Number
			//$partNo = getPartNo($row);
			$html.= "<button type='button' class='btn btn-success' style='float:right' 
						onClick='window.location=\"addpart.php?pid=$row[id]\"'>
						Edit <span class='glyphicon glyphicon-pencil'></span>
					</button>";
			$html .= "<table class='table table-bordered table-hover table-striped'>
						<tr><th>Part Number</th><td><a href='part.php?pid=$row[id]'>$row[id]</a></td></tr>
						<tr><th>Description</th><td><a href='part.php?pid=$row[id]'>$row[description]</a></td></tr>
						<tr><th>Part Category</th><td>$row[category]</td></tr>
						<tr><th>Common Code #</th><td>$row[commonCode]</td></tr>
						<tr><th>Spare Part</th><td>$row[spare]</td></tr>
						<tr><th>Price</th><td>$row[price]</td></tr>
						<tr><th>Vendor</th><td>$row[vendor]</td></tr>
						<tr><th>Vendor Part #</th><td>$row[vendorPartNo]</td></tr>
						<tr><th>Vendor Lead Time</th><td>$row[vendorLeadTime]</td></tr>
						<tr><th>Our Cost</th><td>$row[cost]</td></tr>
						<tr><th>Our Lead Time</th><td>$row[mortechLeadTime]</td></tr>
						<tr><th>Part for SD1500?</th><td>$row[sd1500]</td></tr>
						<tr><th>Part for SD1500s?</th><td>$row[sd1500s]</td></tr>
						<tr><th>Part for SDX?</th><td>$row[sdx]</td></tr>
						<tr><th>Part for HD2500?</th><td>$row[hd2500]</td></tr>
						<tr><th>Part for HDX?</th><td>$row[hdx]</td></tr>
						<tr><th>Minimum Order Requirement</th><td>$row[minOrderReq]</td></tr>
						<tr><th>Unit of Measure</th><td>$row[uom]</td></tr>
						<!--<tr><th>Edit</th><td><a href='#' onClick='document.getElementById(\"view\").style.display=\"none\";document.getElementById(\"edit\").style.display=\"table-row\";'><span class='glyphicon glyphicon-pencil'></span></a></td></tr>-->
						</table>";
		}
	}
	return $html;
}