<?php

include_once('util.php');
include_once('loggedin.php');
include_once('ptoRequest.php');

include('top.php');
echo head("Paid Time Off (PTO)");
echo panel("PTO Request",ptoRequestForm());
include('bottom.php');


?>
