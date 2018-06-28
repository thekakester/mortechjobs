<?php 
include('util.php');

//$_SESSION['permCreateUser']=true;

if(!session('permCreateUser')){
	echo "No Permission";
	exit();
}

echo "Create User";

$user=post('user');
$pass=post('pass');

if($user&&$pass){
	//encrypt password
	$pass=crypt($pass,false);
	
	//check that username doesn't already exist
	$conn->query("INSERT INTO users(user,pass) VALUES('$user','$pass')");
	
}

echo '<br>' . time();

?>

<html>
<body>

	<form method="post">
		<label name="user">User</label><input type="text" name="user"></input><br />
		<label name="pass">Password</label><input type="text" name="pass"></input><br />
		<input type="submit"></input>
	</form>

</body>
</html>

