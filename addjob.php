<?php

include_once('util.php');
include_once('loggedin.php');
include_once('newJob.php');

include('top.php');
echo head("Add Job");
echo panel("Add a Job",newJob());
include('bottom.php');


?>
