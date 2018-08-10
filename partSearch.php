<?php
	//include_once('loggedin.php');
	include_once("util.php");
	
	$searchValue = get("q");
	
	//$q = "SELECT * FROM (parts JOIN part_aliases ON parts.id = part_aliases.partId LEFT JOIN vendors ON vendor=vendors.id)";
	$q = "SELECT DISTINCT parts.id,description,commonCode,category,alias FROM (parts JOIN part_aliases ON parts.id = part_aliases.partId LEFT JOIN vendors ON vendor=vendors.id)";
	if	($searchValue) {
		$q .= " WHERE description LIKE '$searchValue%' OR alias LIKE '$searchValue%' OR commonCode LIKE '$searchValue%' OR name LIKE '$searchValue%'";
	}
	$q .= " ORDER BY id";
	//echo $q;
	$resultset=$conn->query($q);
	
	$id = uniqueID();
	echo "<table id='$id' class='table table-bordered table-hover table-striped'>";
	echo "<tr><th>Part Number</th>
				<th>Alias</th>
				<th>Category</th>
				<th>Description</th>
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
		/*if ($row['spare']==1){
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
		}*/
		
		echo "<tr>
				<td><a href='part.php?pid=$row[id]'>$partNo</a></td>
				<td><a href='part.php?pid=$row[id]'>$row[alias]</a></td>
				<td>$cat</td>
				<td><a href='part.php?pid=$row[id]'>$row[description]</a></td>";
				//<td>$spare</td>
				//<td>$sd1500</td>
				//<td>$hd2500</td>
			//</tr>";
	}
	echo "</table>";
	
	
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
	if ($cat==1){
		return "A-";
	}else{
		return "T-";
	}
}
?>