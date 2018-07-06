<?php

include_once('util.php');
include_once('loggedin.php');
include_once('newTask.php');

include('top.php');
echo head("Add Task");
echo panel("Add a Task",newTask());
include('bottom.php');


?>
