<?php

include_once('util.php');
include_once('loggedin.php');
include_once('taskList.php');

include('top.php');
echo head("Tasks");
echo panel("My Tasks",taskList());
echo panel("All tasks",allTasks());
include('bottom.php');


?>
