<?php

include_once('util.php');
include_once('loggedin.php');
include_once('ptoRequest.php');
include_once('ptoCalendar.php');

include('top.php');
echo head("Personal Time Off (PTO)");
echo panel("PTO Request",ptoRequestForm());
echo panel("Calendar",ptoCalendar());
include('bottom.php');


?>
