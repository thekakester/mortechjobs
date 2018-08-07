<?php

include_once('util.php');
include_once('loggedin.php');
include_once('jobList.php');

include('top.php');
echo head("Jobs");
echo panel("My Jobs",jobList());
include('bottom.php');


?>
