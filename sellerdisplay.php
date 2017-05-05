<?php

//Create connection to database\
$serverName = "ARCADECOMP-PC\SQLEXPRESS"; //serverName\instanceName

$connectionInfo = array( "Database"=>"GarageSales");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}

$sellerdisplay = array();

$usersquery = "SELECT * FROM SellerDetails WHERE SellerUniqID = 25690";

$userqueryresults = sqlsrv_query($conn,$usersquery);

$x = 0;

//array_push($sellerdisplay,3);

while($userquerydata = sqlsrv_fetch_array($userqueryresults))
	{


		array_push($sellerdisplay,$userquerydata);

		echo "<pre>";
		
		print_r(json_encode($userquerydata));
		
		echo "</pre>";
		$x++;
	}

?>


<!DOCTYPE HTML>
<html>
	<head>
	</head>
	<body>
		<script>
			var sellerinformation = <?php echo json_encode($sellerdisplay); ?>;
			console.log(sellerinformation);


			for(x = 0; x < sellerinformation.length; x++)
			{
				if(sellerinformation[x]['SellerCategoryID'] == 6)
				{
					document.write("<img src='images\'_25690\'default.jpg'/>");
				}

			}
		</script>
		<img src="images\_25690\default.jpg" />
	</body>
</html>