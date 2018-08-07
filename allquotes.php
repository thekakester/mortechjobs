<?php

include_once('util.php');
include_once('loggedin.php');
include_once('quoteList.php');

include('top.php');
echo head("Quotes");
echo panel("My Quotes",quoteList());
echo panel("All Quotes",allQuotes());
include('bottom.php');


?>
