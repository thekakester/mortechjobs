<?php 

session_start();

//This is used when sending out emails with hyperlinks
$server_ip = "http://168.192.1.131";

$conn=new mysqli();
$conn->connect("127.0.0.1","root",false,"mortech_jobs");

$uid=session('uid');
$__username = false;	//Gets changed when getUsername() is called

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

//WARNING: Not guaranteed to be unique!
function generateToken() {
	$token = "";
	for ($i = 0; $i < 32; $i++) {
		$token .= chr(rand(97,122));
	}
	return $token;
}

function beginningOfDayUTC($utc) {
	return strToTime("today",$utc);
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

function head($title) {
return "	<div class='row'>
                <div class='col-lg-12'>
                    <h1 class='page-header'>$title</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>";
}
?>

