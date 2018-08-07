<?php

include_once("util.php");
include_once('sortyTable.php');

function partList() {
	global $conn,$uid;
	$id = uniqueID();
	$resultset=$conn->query("SELECT * FROM parts ORDER BY id");
	$html = "<table id='$id' onload='makeSorty(this)' class='table table-bordered table-hover table-striped'>";
	$html .= "<tr><th>Part Number</th>
				<th>Category</th>
				<th>Description</th>
				<th>Spare</th>
				<th>SD1500</th>
				<th>HD2500</th>
				</tr>";
	while ($row=$resultset->fetch_assoc()){
		//Part Number
		$partNo = getPartNo($row);
		
		//category
		if ($row['category']==1){
			$cat="AGC";
		} else {
			$cat="Tool";
		}
		
		//spare
		if ($row['spare']==1){
			$spare="Yes";
		} else {
			$spare="No";
		}
		
		//sd1500
		if ($row['sd1500']==1){
			$sd1500="Yes";
		} else {
			$sd1500="No";
		}
		
		//hd2500
		if ($row['hd2500']==1){
			$hd2500="Yes";
		} else {
			$hd2500="No";
		}
		
		$html .= "<tr>
				<td><a href='part.php?pid=$row[id]'>$partNo</a></td>
				<td>$cat</td>
				<td><a href='part.php?pid=$row[id]'>$row[description]</a></td>
				<td>$spare</td>
				<td>$sd1500</td>
				<td>$hd2500</td>
			</tr>";
	}
	$html .= "</table>";
	$html .= "<script>$(document).ready(function(){ makeSorty(document.getElementById('$id')) }) </script>";
	return $html;
}

function getPartNo($row){
	
	$zeros=6-strlen($row['id']);
	$partNo="MT".getCatLetter($row['category']);
	
	for ($i=0;$i<$zeros;$i++){
			$partNo=$partNo."0";
	}
	return $partNo.$row['id'];
}

function getCat($cat){
	if ($cat=1){
		return "AGC Part";
	}else{
		return "Tool Part";
	}
}

function getCatLetter($cat){
	if ($cat=1){
		return "A-";
	}else{
		return "T-";
	}
}

?>