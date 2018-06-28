<?php
include('util.php');

if(get('logout')){
	session_destroy();
	echo "Logged Out";
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

echo "Invalid credentials";

?>

<html>
<body>

	<form method="post">
		<label name="user">User</label><input type="text" name="user"></input><br />
		<label name="pass">Password</label><input type="password" name="pass"></input><br />
		<input type="submit"></input>
	</form>

</body>
</html>
