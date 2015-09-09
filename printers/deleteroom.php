<?PHP

require "../config/config.php";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link href='../adminwhite.css' rel='stylesheet' type='text/css'>
<title>Add New Room</title>
</head>
<body>
<center>
<?PHP

if (isset($_GET['DID']))
{
$DID = $_GET['DID'];

mysqli_query($con,"DELETE FROM  `InkStock`.`Departments` WHERE  `Departments`.`DID` =$DID;");


echo "Please wait....";
}
else {
echo "Data Invalid";
}
?>
<script>
setTimeout(function(){window.history.back()}, 1000);
</script>
<!-- 
##################################################
################# Not Logged in ##################
##################################################
-->

</center>
</body>
</html>