<?php

//Get from signup.php form

$selleruniqID = rand();
$signupinputs = array();
$signupinputs[0] = array();

$v = 0;

foreach($_FILES['file']['name'] as $filename)
	{
		if($filename)
		{
			$signupinputs[0][$v]['filename'] = $filename;
			$v++;
		}
	}

 $v = 0;

foreach($_FILES['file']['tmp_name'] as $filetmp)
	{
		if($filetmp)
		{
			$signupinputs[0][$v]['tmpname'] = $filetmp;
			$v++;
		}
	}

array_push($signupinputs ,$_POST['fname']);
array_push($signupinputs ,$_POST['lname']);
array_push($signupinputs ,$_POST['pnumber']);
array_push($signupinputs ,$_POST['staddress']);
array_push($signupinputs ,$_POST['zipaddress']);
array_push($signupinputs ,$selleruniqID);


print_r(json_encode($signupinputs));


//Create connection to database\
$serverName = "ARCADECOMP-PC\SQLEXPRESS"; //serverName\instanceName

$connectionInfo = array( "Database"=>"GarageSales");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}

//insert into dbo.Sellers

$insertsellers = "INSERT INTO Sellers (SellerUniqID, DateTime) VALUES ('".$signupinputs[6]."','".date("Y/m/d h:s:m")."')";
sqlsrv_query($conn,$insertsellers);

//insert into dbo.SellerDetails

$insertsellersdetailsquery= "INSERT INTO SellerDetails (SellerUniqID,SellerCategoryID,Details) VALUES ('".$signupinputs[6]."','1','".$signupinputs[1]."')";
sqlsrv_query($conn,$insertsellersdetailsquery);

$insertsellersdetailsquery= "INSERT INTO SellerDetails (SellerUniqID,SellerCategoryID,Details) VALUES ('".$signupinputs[6]."','2','".$signupinputs[2]."')";
sqlsrv_query($conn,$insertsellersdetailsquery);

$insertsellersdetailsquery= "INSERT INTO SellerDetails (SellerUniqID,SellerCategoryID,Details) VALUES ('".$signupinputs[6]."','3','".$signupinputs[3]."')";
sqlsrv_query($conn,$insertsellersdetailsquery);

$insertsellersdetailsquery= "INSERT INTO SellerDetails (SellerUniqID,SellerCategoryID,Details) VALUES ('".$signupinputs[6]."','4','".$signupinputs[4]."')";
sqlsrv_query($conn,$insertsellersdetailsquery);

$insertsellersdetailsquery= "INSERT INTO SellerDetails (SellerUniqID,SellerCategoryID,Details) VALUES ('".$signupinputs[6]."','5','".$signupinputs[5]."')";
sqlsrv_query($conn,$insertsellersdetailsquery);

mkdir('C:\xampp\htdocs\GarageSales\images/_'.$signupinputs[6]);

//images
for ($x = 0; $x < count($signupinputs[0]); $x++)
	{
		$insertsellersdetailsquery = "INSERT INTO SellerDetails (SellerUniqID,SellerCategoryID,Details) VALUES ('".$signupinputs[6]."','6','".$signupinputs[0][$x]['filename']."')";
		sqlsrv_query($conn,$insertsellersdetailsquery);


		//create directories image files from sign.php form

		$targetdir ="images/_".$signupinputs[6]."/".$signupinputs[0][$x]['filename'];

		if (move_uploaded_file($signupinputs[0][$x]['tmpname'], $targetdir)) {
		    echo "Uploaded";
		    echo $signupinputs[0][$x]['filename'];	
		} else {
		   echo "File was not uploaded";
		   echo $signupinputs[0][$x]['filename'];	
		}		
	}


/*Sample
$usersquery = "SELECT * FROM Sellers";
$userqueryresults = sqlsrv_query($conn,$usersquery);
while($userquerydata = sqlsrv_fetch_array($userqueryresults))
	{
		print_r(json_encode($userquerydata));
	}
*/



?>