<?php
/*http://localhost:8080/GarageSales/signupfilecreate.php?fname=salim&lname=test&pnumber=4698313893&staddress=5409delreydrive&zipaddress=76208&file[]=132132&file[]=56498798*/	
//Get from signup.php form

$signupinputs = array();
$signupinputs[0] = array();

foreach($_GET['file'] as $files)
	{
		array_push($signupinputs[0], $files);
	}

if(!$_GET['fname'])
	{
		echo ERROR;
	} 
else {
	 	array_push($signupinputs ,$_GET['fname']);
	};

array_push($signupinputs ,$_GET['lname']);
array_push($signupinputs ,$_GET['pnumber']);
array_push($signupinputs ,$_GET['staddress']);
array_push($signupinputs ,$_GET['zipaddress']);



print_r(json_encode($signupinputs));



//Create connection to database\

$servername = 'localhost';
$username = 'root';
$password = '';

// Create connection
$conn = new mysqli($servername, $username, $password, 'treasurezen');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$sql = "SELECT * FROM zipcodetypes";
$result = $conn->query($sql);
	
//insert into database



//create directories image files from sign.php form
/*
$dirname = "/xampp/htdocs/GarageSales/images";
$images = scandir($dirname);
print_r($images);

$oldpath = getcwd();
chdir('/xampp/htdocs/GarageSales/images');
echo getcwd();
*/


?>