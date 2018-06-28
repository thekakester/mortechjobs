<?php
	include "util.php";
	include "autocomplete.php";
?>

<!--Move this line to util.php so all pages get jquery!!!-->





<?php
	echo autoCompleteTextbox("users","");
	echo autoCompleteTextbox("users","");
	echo autoCompleteTextbox("users","");
	echo "<br>";
	echo autoCompleteTextbox("users","");
	echo "<br><table border=1 cellpadding=100><tr><td>" . autoCompleteTextbox("users","") . "</td></tr></table>";
?>

<script>
$( function() {
	$( "#datepicker" ).datepicker();
} );
</script>
<input type="text" id="datepicker"/>