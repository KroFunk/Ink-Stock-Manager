<?PHP
session_start();
require "../config/config.php";
if(isset($_GET['index'])){$index = $_GET['index'];}


if (@$_FILES["csv"]["size"] > 0) { 
  
$logcheck = mysqli_query($con, "SELECT * FROM `pcounter` WHERE `LogFileName` LIKE '".$_FILES["csv"]["name"]."'") or die ('Unable to execute query. '. mysqli_error($con));
$logcheckresult = mysqli_fetch_array($logcheck);


if(empty($logcheckresult['LogFileName'])){



    //get the csv file 
    $file = $_FILES["csv"]["tmp_name"]; 
    $handle = fopen($file,"r"); 
    //$title = $_POST['title'];
	
	
    //loop through the csv file and insert into database 
    do { 
        if (isset($data[0])) { 
 //         echo "INSERT INTO `pcounter` (`User`, `Document`, `PrinterModel`, `Date`, `Time`, `Computer`, `Department`, `Paper Size`, `CommandString`, `Pages`, `Cost`, `LogFileName`, `Index`) VALUES 
   //             ( 
     //     '".substr(addslashes($data[0]),11)."',
       //   '". utf8_encode(addslashes($data[1])) ."',
				//	'".substr(addslashes($data[2]),11)."',
					//'".addslashes($data[3])."',
					//'".addslashes($data[4])."',
					//'".addslashes($data[5])."',
					//'".addslashes($data[6])."',
					//'".addslashes($data[8])."', 
          //'". utf8_encode(addslashes($data[9])) ."', 
					//'".addslashes($data[11])."', 
					//'".addslashes($data[12])."',
          //'". $title . "<br/>";
          
          
          
            mysqli_query($con, "INSERT INTO `pcounter` (`User`, `Document`, `PrinterModel`, `Date`, `Time`, `Computer`, `Department`, `Paper Size`, `CommandString`, `Pages`, `Cost`, `LogFileName`, `Index`) VALUES 
                ( 
          '".substr(addslashes($data[0]),11)."',
          '". utf8_encode(addslashes($data[1])) ."',
					'".substr(addslashes($data[2]),11)."',
					'".addslashes(date('Y-d-m',strtotime($data[3])))."',
					'".addslashes($data[4])."',
					'".addslashes($data[5])."',
					'".addslashes($data[6])."',
					'".addslashes($data[8])."', 
          '". utf8_encode(addslashes($data[9])) ."', 
					'".addslashes($data[11])."', 
					'".addslashes($data[12])."',
          '". $_FILES["csv"]["name"] ."',
          NULL
                )
            ") or die ('Unable to execute query. '. mysqli_error($con));
			set_time_limit(30);
         } 
    } while ($data = fgetcsv($handle,500,",","'")); 
    // 

    //redirect 
    //header('Location: addnew.php?success=1'); die; 
    
$result = mysqli_query($con, "SELECT * FROM `AuditTrail`\n" . "ORDER BY `AuditTrail`.`AID` DESC LIMIT 0, 1 ");
//if (!$check1_res) {
  //  printf("%s\n", mysqli_error($con));
//}

//$index = mysqli_num_rows($result) + 1;
$row = mysqli_fetch_array($result);
$AID = $row['AID'] + 1;

$note = 'Logname: ' . $_FILES["csv"]["name"];
$theDate = date('Y') . "-" . date('m') . "-" . date('d');
$theTime = date('H') . ":" . date('i');
$UserID = $_SESSION['CUID'];
$detail = 'PCounter Log uploaded';
    
mysqli_query($con,"INSERT INTO  `InkStock`.`AuditTrail` (
`AID` ,
`Date` ,
`Time` ,
`UserID` ,
`Printer` ,
`InkName` ,
`Cost` ,
`Department` ,
`Detail` ,
`Note`
)
VALUES ('$AID',  '$theDate',  '$theTime', '$UserID', '-',  '-',  '-',  '-',  '$detail',  '$note');");

    
    echo "<div style='text-align:center;color:white;background:#1F1F1F;'><b>" . $_FILES["csv"]["name"] . " has been uploaded! You may now close this window.</b></div>";
}
else {
    echo "<div style='text-align:center;color:white;background:#c40000;'><b>" . $_FILES["csv"]["name"] . " already exists in the database!</b></div>";
}
} 

//print_r($_FILES);
//echo $_FILES['csv']['error'];


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link href='../adminwhite.css' rel='stylesheet' type='text/css'>
<title>Add New Log Data</title>
</head>
<body>
<center>

<h1>Add New Log Data</h1>
<?php if (!empty($_GET['success'])) { ?>
<div id="notify" style="opacity:0; position:absolute; top:5px; left:50%; width:230px; margin-left:-115px; font-size:12px; border:red 1px solid; background:yellow; padding:5px; text-align:center;">
Your log has been imported successfully.
</div>
<?php } ?>

<div id="target">
<p style='text-align:left;'>Use this form to import new PCounter Log Data. <br/><b>Note:</b> The import may take some time, depending on size and server load. <br/><i>During this time the webpage may seem unresponsive.</i></p>

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
<table style="border:none;">
<tr><td>Log File</td><td style="border:none;"></td></tr>
<tr>
<td><input name="csv" type="file" id="csv" /></td>
<td></td></tr></table>
<input type="button" class="button" onclick="parent.closewrapper();" name="" value="Cancel">
<input type="button" onclick="importcsv()" name="Submit" class="submit" value="Submit" />
</form> 
</div>
<script>
form=document.getElementById("form1");
target=document.getElementById("target");
var timeout;
function importcsv() {
target.innerHTML = "<center><img src='moss.gif' style='padding:5px;' /><br/><div class='spinner'></div>Working, Please Wait.</center><br/>";
timeout = window.setTimeout(submitform,200);
}
function submitform() {
form.submit();
}
</script>
</center>
</body>
</html>