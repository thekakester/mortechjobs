<?php

include_once('util.php');
include_once('loggedin.php');
include_once('newPart.php');

include('top.php');
echo head("Add Part");
echo panel("Add a Part",newPart());
include('bottom.php');


?>
