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

if (isset($_GET['pid'], $_GET['room']))
{
$pid = $_GET['pid'];
$room = $_GET['room'];

mysqli_query($con,"INSERT INTO `InkStock`.`Departments` (`DID`, `Room`, `PID`) VALUES (NULL, '$room', '$pid');");

echo $_GET['room'] . " has been created.<br />";
echo "Please wait....";
}
else {
echo "Data Invalid";
}
?>
<script>
setTimeout(function(){window.history.back()}, 1500);
</script>
<!-- 
##################################################
################# Not Logged in ##################
##################################################
-->

</center>
</body>
</html>