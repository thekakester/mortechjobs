<?php
include('top.php');

?>

<script>
	function refreshpdf(){
		document.myform.submit();
	};
</script>
<div class='col-xs-6'>
	<form name="myform" action="quotepdf.php" method="post" target="my-iframe">
		<label>Title</label><input name="title" type="text" onChange="refreshpdf()" value="Quotation"><br />
		<label>Customer</label><input name="customer" type="text" onChange="refreshpdf()"><br />
		<label>Estimate #</label><input name="estimate" type="text" onChange="refreshpdf()"><br />
		<label>Date</label><input name="date" type="text" onChange="refreshpdf()"><br />
		<label>Sales Rep.</label><input name="sales" type="text" onChange="refreshpdf()"><br />
		<label>Program #</label><input name="prog" type="text" onChange="refreshpdf()"><br />
		<label>Engineer</label><input name="engineer" type="text" onChange="refreshpdf()"><br />
		<label>Plant</label><input name="plant" type="text" onChange="refreshpdf()"><br />
	</form>
</div>
<div class='col-xs-6'>
	<div style='width:100%'>
		<iframe name='my-iframe' style="width:100%; height:90vh"></iframe>
	</div>
</div>

<?php
include('bottom.php');

?>