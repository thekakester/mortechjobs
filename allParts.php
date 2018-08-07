<?php

include_once('util.php');
include_once('loggedin.php');
include_once('partList.php');

include('top.php');
echo head("Parts");
echo panel("Parts",partList());
include('bottom.php');


?>
