<?php

include('signupfilecreate.php');

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

while($userquerydata = sqlsrv_fetch_array($userqueryresults))
	{
		array_push($sellerdisplay,$userquerydata);
		$x++;
	}


//connect to qrcode api
	$qrcodeurl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=www.ign.com&format=jpeg';
	$qrcodecontents = file_get_contents($qrcodeurl);
	$qrcodeencode = base64_encode($qrcodecontents);
	array_push($sellerdisplay,'data:image/jpeg;base64,'.$qrcodeencode);

 
//testing
echo 'data:image/jpeg;base64,'.$qrcodeencode;
echo "<pre>";	
print_r($sellerdisplay);
echo "</pre>";	



?>


<!DOCTYPE HTML>
<html>
	<head>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script> <!--  Connect to jsPDF -->
	</head>
	<body>
		<script>

		var sellerdisplay = <?php echo json_encode($sellerdisplay); ?>;
		console.log(sellerdisplay);

		//Stand alone qrcode
        var pdf = new jsPDF('landscape');
        var qrcode = sellerdisplay[8]; pdf.addImage(qrcode, 'JPEG', 30, 30, 150, 150);
        pdf.save('QRcodeonly.pdf');	


		//Garage Sale Flyer
        var pdf = new jsPDF('landscape');
        pdf.setFontSize(25);
        pdf.text(140, 30, 'Garage Sale');
        pdf.text(120,60,"Address: " + sellerdisplay[3]['Details'] );
        pdf.text(80,90,"Date: 5/6/2018 9:00am - 5/7/2018 5:00pm");
        var qrcode = sellerdisplay[8]; pdf.addImage(qrcode, 'JPEG', 120, 110, 80, 80);
        pdf.save('GarageSaleFlyer.pdf');

        //4 piece Flyer
       //Part 1 (top left)
        var pdf = new jsPDF('landscape');
		pdf.setFontSize(200);
		pdf.text(60, 80, 'GARAGE SALE');

		pdf.setFontSize(120);
		pdf.text(20, 170, 'ADDRESS: 5409 DEL REY DR');
		pdf.save('GarageSaleFlyerpart1.pdf');

		//Part 2 (top right)
        var pdf = new jsPDF('landscape');
		pdf.setFontSize(200);
		pdf.text(-235, 80, 'GARAGE SALE');

		pdf.setFontSize(120);
		pdf.text(-280, 170, 'ADDRESS: 5409 DEL REY DR');
		pdf.save('GarageSaleFlyerpart2.pdf');		

		//Part 3 (bottom left)
		var pdf = new jsPDF('landscape');
		pdf.setFontSize(120);
		pdf.text(30, 80, 'Date: 5/6/2018 9:00am - 5/7/2018 5:00pm');

        var qrcode = sellerdisplay[8]; pdf.addImage(qrcode, 'JPEG', 30, 120, 80, 80);
		pdf.save('GarageSaleFlyerpart3.pdf');

		//Part 4 (bottom right)
		var pdf = new jsPDF('landscape');
		pdf.setFontSize(120);
		pdf.text(-265, 80, 'Date: 5/6/2018 9:00am - 5/7/2018 5:00pm');
        var qrcode = sellerdisplay[8]; pdf.addImage(qrcode, 'JPEG', 180, 120, 80, 80);
		pdf.save('GarageSaleFlyerpart4.pdf');


        	//testing loop
			for(x = 0; x < sellerdisplay.length; x++)
			{
				if(sellerdisplay[x]['SellerCategoryID'] == 6) //dbo.Sellercategories
				{
					document.write('<img src="images/_'+sellerdisplay[x]['SellerUniqID']+'/'+sellerdisplay[x]['Details']+'"/>');
				}
				else
				{
					document.write(sellerdisplay[x]['Details']);
				}

			}
			document.write( "<img src='"+sellerdisplay[8]+"' />");
		</script>

	</body>
</html>