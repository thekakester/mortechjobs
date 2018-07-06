<?php
include('util.php');

if(get('logout')){
	session_destroy();
	echo "<font style='color:white'>Logged Out</font>";
}

if(session('uid')){
	header("Location:/");
}

if(session('uid')){
	//echo "Logged In";
} else {
	//echo "Not Logged  In";
}

$user=post('user');
$pass=post('pass');

if($user&&$pass){
	$resultset=$conn->query("SELECT * FROM users WHERE user='$user'");
	
	if($row=$resultset->fetch_assoc()){
		//print_r($row);
		//echo "This user exists";
		$passdb=$row['pass'];
		if (crypt($pass,$passdb)==$passdb){
			//echo "You are logged in";
			$_SESSION['uid']=$row['id'];
			$_SESSION['user']=$row['user'];
			
			header("Location:/");
		} else {
			//echo "wrong password";
		}
	} else {
		//echo "This user does not exist";
	}
	
}

echo "<font style='color:white'>Invalid credentials</font>";

?>

<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
	<form method="post" role="form">
		<input type="text" name="user" placeholder="Username" class="form-control"></input><br />
		<input type="password" name="pass" placeholder="Password" class="form-control"></input><br />
		<input type="submit" class="btn btn-lg btn-success btn-block"></input>
	</form>
	</div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>
</html>
