<?php 

session_start();

$conn=new mysqli();
$conn->connect("127.0.0.1","root",false,"mortech_jobs");

$uid=session('uid');

if($uid){
	$resultset=$conn->query("SELECT * FROM permissions WHERE uid=$uid ORDER BY id DESC LIMIT 1");
	if($row=$resultset->fetch_assoc()){
		foreach($row as $key=>$val){
			if($key=="id"||$key=="utc"||$key=="uid"){
				continue;
			}
			$_SESSION[$key]=$val;
		}	
	}
}

function get($val){
	if (isset($_GET[$val])){ 
		return $_GET[$val];
	}
	return false;
}

function session($val){
	if (isset($_SESSION[$val])){ 
		return $_SESSION[$val];
	}
	return false;
}

function post($val){
	if (isset($_POST[$val])){ 
		return $_POST[$val];
	}
	return false;
}

$uniqueID = 0;
function uniqueID() {
	global $uniqueID;
	return "uniqueID" . $uniqueID++;
}

function panel($title,$html) {
	return "<div class='panel panel-default'>
                        <div class='panel-heading'>
                            <i class='fa fa-bar-chart-o fa-fw'></i>$title
                        </div>
                        <!-- /.panel-heading -->
                        <div class='panel-body'>
                            $html
                        </div>
                        <!-- /.panel-body -->
                    </div>";
}

?>
<script src="jquery-3.3.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">