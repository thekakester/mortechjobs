<?php

include_once('util.php');
include_once('taskList.php');
include_once('loggedin.php');


include('top.php');
echo head("Dashboard");
echo panel("My Tasks",taskList());
include('bottom.php');
?>