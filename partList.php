<?php

include_once("util.php");
include_once('sortyTable.php');

function partList() {
	$html = "<input type='text' placeholder='Search' onKeyUp='updateResults(this)'>
			<div id='partlist'></div>";
			
	$html .= "<script>$(document).ready(function(){ $('#partlist').load('partSearch.php'); }); 
		function updateResults(textbox) {
			$('#partlist').load('partSearch.php?q=' + escape(textbox.value));
		}
	</script>";
	return $html;
}

?>