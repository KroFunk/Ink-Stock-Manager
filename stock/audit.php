<?PHP

date_default_timezone_set('GMT');
require "../config/config.php";
if(isset($_GET['index'])){$index=$_GET['index'];}else {$index="";}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link href='adminwhite.css' rel='stylesheet' type='text/css'>
<title><?PHP echo $_GET['utitle']; ?></title>
<script>
function openwrapper(url){
document.getElementById('iframewrapper').style.display='block'; 
document.getElementById('grey').style.display='block';
 document.getElementById('Iframe').src = url;
}
</script>
</head>
<body>
<center>
<?PHP
if (1 == 1) {


if (isset($_GET['printer'])) {

$result = mysqli_query($con, "SELECT * FROM `AuditTrail`\n" . "ORDER BY `AuditTrail`.`AID` DESC LIMIT 0, 1 ");
//if (!$check1_res) {
  //  printf("%s\n", mysqli_error($con));
//}

//$index = mysqli_num_rows($result) + 1;
$row = mysqli_fetch_array($result);
$AID = $row['AID'] + 1;

$printer = $_GET['printer'];
$inkname = $_GET['inkname'];
$cost = $_GET['cost'];
$department = $_GET['department'];
$note = $_GET['note'];
$theDate = date('Y') . "-" . date('m') . "-" . date('d');
$theTime = date('H') . ":" . date('i');
$UserID = $_SESSION['CUID'];
$detail = $_GET['detail'];

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
VALUES (
'$AID',  '$theDate',  '$theTime', '$UserID', '$printer',  '$inkname',  '$cost',  '$department',  '$detail',  '$note'
);");
//if (!$check1_res) {printf("%s\n", mysqli_error($con));}


echo "Action has been completed.<br />...Please Wait...";
echo "<script>
    setTimeout(function(){ parent.reloadparent(); }, 1000);
</script>";
if ($_GET['redirect'] == ""){
//nothing
}
else{
?>
<script>
window.location.assign("<?php echo $_GET['redirect'];?>");
</script>
<?PHP
}
}

else {

echo "Audit data not complete!";

 } ?>


<!-- 
##################################################
################# Not Logged in ##################
##################################################
-->

<?PHP
 }
else { 
?>
you not logged in bro!
<?PHP }?>
</center>
</body>
</html>