<?php

include_once("util.php");
include_once "autocomplete.php";

function newPart() {
	global $conn,$uid;
	$id = uniqueID();
	
	
	//loop through all part categories, add to dropdown list
	$optionList = "";
	$resultSet = $conn->query("SELECT id,description FROM categories ORDER BY description ASC");
	while ($row = $resultSet->fetch_assoc()) {
		$optionList .= "<option value='$row[id]'>$row[description]</option>";
	}
	
	$html="<form role='form' method='post'>
			<div class='form-group'>
                <label>Description</label>
                <input type='test' class='form-control' name='description' autocomplete='off' required>
            </div>
			<div class='form-group'>
                <label>Other Names</label>
                <textarea rows='3' class='form-control' placeholder='[One Per Line]\nExample-1\nExample-2' name='aliases'></textarea>
            </div>
			<div class='form-group'>
				<label>Select Part Category</label>
				<select class='form-control' name='category' required>";
				
	
	$html .= $optionList;
		
	$html.= "</select>
					</div>
					<div class='form-group'>
                        <label>Common Code Number</label>
                        <input class='form-control' type='text' name='commonCode' autocomplete='off'>
                    </div>
					<div class='form-group'>
                        <label>Spare Part?</label><br>
                        <label class='radio-inline'><input type='radio' name='spare' value='1'>Yes</label>
						<label class='radio-inline'><input type='radio' name='spare' value='0' checked>No</label>
                    </div>
					<div class='form-group'>
                        <label>Cost</label>
                        <input type='text' class='form-control' name='cost' autocomplete='off'>
                    </div>
					<div class='form-group'>
                        <label>Price</label>
                        <input type='text' class='form-control' name='price' autocomplete='off'>
                    </div>
					<div class='form-group'>
						<label>Select Vendor</label>";
					$html .= autoCompleteTextbox("vendors","class='form-control' name='vendor'");
					$html .= "</div>
					<div class='form-group'>
                        <label>Vendor Part Number</label>
                        <input class='form-control' type='text' name='vendorPartNo' autocomplete='off'>
                    </div>
					<div class='form-group'>
                        <label>Vendor Lead Time</label>
                        <input class='form-control' type='text' name='vendorLeadTime' autocomplete='off'>
                    </div>
					<div class='form-group'>
                        <label>MorTech Lead Time</label>
                        <input class='form-control' type='text' name='mortechLeadTime' autocomplete='off'>
                    </div>
					<div class='form-group'>
						<input type='checkbox' name='sd1500'><label>SD1500</label><br>
						<input type='checkbox' name='sd1500s'><label>SD1500s</label><br>
						<input type='checkbox' name='sdx'><label>SDX</label><br>
						<input type='checkbox' name='hd2500'><label>HD2500</label><br>
						<input type='checkbox' name='hdx'><label>HDX</label>
					</div>
					<div class='form-group'>
						<label>Minimum Order Requirement</label>
						<input type='text' class='form-control' name='minOrderReq' autocomplete='off'>
					</div>
					<div class='form-group'>
                        <label>Unit of Measure</label>";
					$html .= autoCompleteTextbox("uom","class='form-control' name='uom' required");
                    $html .= "
                    </div>
					<input type='submit' value='Add Part' class='btn btn-success mb-2'>
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
}


function onOff($value) {
	if ($value == "on") { return 1; }
	return 0;
}

//Return NULL if the string is empty or FALSE.  Otherwise return the value back with single quotes
function emptyStringToNull($value) {
	if ($value == "" || $value === false) { return "NULL"; }
	return "'$value'";
}


//ON SUBMIT
$commonCode 		= emptyStringToNull(post("commonCode"));
$category			= post("category");
$description 		= post("description");
$aliases			= post("aliases");
$spare 				= emptyStringToNull(post("spare"));
$cost 				= emptyStringToNull(post("cost"));
$price 				= emptyStringToNull(post("price"));
$vendorPartNo 		= emptyStringToNull(post("vendorPartNo"));
$vendorLeadTime 	= emptyStringToNull(post("vendorLeadTime"));
$mortechLeadTime 	= emptyStringToNull(post("mortechLeadTime"));
$sd1500 			= onOff(post("sd1500"));
$sd1500s 			= onOff(post("sd1500s"));
$sdx 				= onOff(post("sdx"));
$hd2500 			= onOff(post("hd2500"));
$hdx 				= onOff(post("hdx"));
$minOrderReq 		= emptyStringToNull(post("minOrderReq"));
$uom 				= post("uom");
$vendor 			= emptyStringToNull(post("vendor"));

if ($category && $description && $uom) {
	
	try {
		$vendorID = 1;
		$q = "INSERT INTO parts (category,spare,description,commonCode,vendor,vendorPartNo,vendorLeadTime,mortechLeadTime,cost,price,sd1500,sd1500s,sdx,hd2500,hdx,minOrderReq,uom) VALUES('$category',$spare,'$description',$commonCode,$vendorID,$vendorPartNo,$vendorLeadTime,$mortechLeadTime,$cost,$price,$sd1500,$sd1500s,$sdx,$hd2500,$hdx,$minOrderReq,'$uom')";
		$result = $conn->query($q);
		echo $q . "<br>";
		if ($result) {
			header("Location: allparts.php");
		} else {
			echo "ERROR HAS OCCURRED";
		}
		
		$partId = $conn->insert_id;
		
		//Split the aliases up
		if ($aliases) {
			$aliasArray = explode("\n",$aliases);
			foreach ($aliasArray as $alias) {
				$alias = trim($alias);
				if ($alias == "") {continue;}
				$conn->query("INSERT INTO part_aliases (partId,alias) VALUES($partId,'$alias')");
			}
		}
		$conn->commit();
	} catch (Exception $e) {
		$conn->rollback();
		throw $e;
	}
}
?>

