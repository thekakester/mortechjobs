<?php 
include('util.php');

//$_SESSION['permCreateUser']=true;

if(!session('permCreateUser')){
	echo "No Permission";
	exit();
}

//echo "Create User";

$user=post('user');
$pass=post('pass');
$fname=post('fname');
$lname=post('lname');
$email=post('email');
$title=post('title');

if($user&&$pass){
	//encrypt password
	$pass=crypt($pass,false);
	
	//check that username doesn't already exist
	$conn->query("INSERT INTO users(user,pass,fname,lname,email,title) VALUES('$user','$pass','$fname','$lname','$email','$title')");
	
}

//echo '<br>' . time();

?>

<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Create User</title>

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
		<h1>Create User</h1>
		<form method="post">
			<div class="form-group">
				<label name="user" >User</label><input class="form-control" type="text" name="user" placeholder="Username">
			</div>
			<div class="form-group">
			<label name="pass">Password</label><input class="form-control" type="text" name="pass" placeholder="Password">
			</div>
			<div class="form-group">
			<label name="user">First Name</label><input class="form-control" type="text" name="fname" placeholder="First Name">
			</div>
			<div class="form-group">
			<label name="user">Last Name</label><input class="form-control" type="text" name="lname" placeholder="Last Name">
			</div>
			<div class="form-group">
			<label name="user">E-Mail</label><input class="form-control" type="text" name="email" placeholder="E-Mail">
			</div>
			<div class="form-group">
			<label name="user">Title</label><input class="form-control" type="text" name="title" placeholder="Title">
			</div>
			<input type="submit" class="btn btn-success mb-2">
		</form>
	</div>

</body>
</html>

