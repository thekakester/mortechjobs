<?php

include_once("util.php");

function newPart() {
	global $conn,$uid;
	$id = uniqueID();
	
	$html="<form role='form' method='post'>
			<div class='form-group'>
                <label>Description</label>
                <textarea class='form-control' rows='3' name='description' requried></textarea>
            </div>
			<div class='form-group'>
				<label>Select Part Category</label>
				<select class='form-control' name='category' requried>
					<option> </option>
					<option>AGC Part</option>
					<option>Tool Part</option>";
		//loop through all part categories, add to dropdown list
	$html.= "</select>
					</div>
					<div class='form-group'>
                        <label>Common Code Number</label>
                        <input class='form-control' type='text' name='commonCode'>
                    </div>
					<div class='form-group'>
                        <label>Spare Part?</label><br>
                        <label class='radio-inline'><input type='radio' name='spare' value='yes'>Yes</label>
						<label class='radio-inline'><input type='radio' name='spare' value='no' checked>No</label>
                    </div>
					<div class='form-group'>
                        <label>Price</label>
                        <input type='text' class='form-control' name='price'>
                    </div>
					<div class='form-group'>
						<label>Select Vendor</label>
						<select class='form-control'  name='owner'>
							<option></option>
							<option>McMaster Carr</option>
							<option>Company Products</option>";
							//loop through all vendors, add to dropdown list
					$html.="<option>Vendor A</option>
							<option>Vendor B</option>
							<option>Vendor C</option>
							<option>Vendor D</option>
						</select>
					</div>
					<div class='form-group'>
                        <label>Vendor Part Number</label>
                        <input class='form-control' type='text' name='vendorPartNo'>
                    </div>
					<div class='form-group'>
                        <label>Vendor Lead Time</label>
                        <input class='form-control' type='text' name='vendorLeadTime'>
                    </div>
					<div class='form-group'>
                        <input type='checkbox' name='sd1500'><label>SD1500</label>
                    </div>
					<div class='form-group'>
                        <input type='checkbox' name='sd1500s'><label>SD1500s</label>
                    </div>
					<div class='form-group'>
                        <input type='checkbox' name='SDX'><label>SDX</label>
                    </div>
					<div class='form-group'>
                        <input type='checkbox' name='hd2500'><label>HD2500</label>
                    </div>
					<div class='form-group'>
                        <input type='checkbox' name='HDX'><label>HDX</label>
                    </div>
					<div class='form-group'>
                        <label>Minimum Order Requirement</label>
                        <input type='text' class='form-control' name='minOrderReq'>
                    </div>
					<div class='form-group'>
                        <label>Unit of Measure</label>
                        <input type='text' class='form-control' name='uom'>
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

?>

