<?PHP

require "../config/config.php";
$index = $_GET['index'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link href='adminwhite.css' rel='stylesheet' type='text/css'>
<title>Add Stock</title>
</head>
<body>
<center>
<?PHP
if (isset($_GET['index'])) {

if (isset($_POST['submit'])) {

$result = mysqli_query($con, "SELECT * FROM Stock INNER JOIN Printers ON Printers.PID=Stock.PID  WHERE `Stock`.`IID` = $index;");

echo "Entry No: " . $index . "<br />";

$newvalue = $_POST['NowOnOrder'];

mysqli_query($con,"UPDATE  `InkStock`.`Stock` SET  `OnOrder` =  '$newvalue' WHERE  `Stock`.`IID` =$index;");

echo "Please Wait...";

while($row = mysqli_fetch_array($result))
  {
  $printer = $row['PrinterMake'] . " " . $row['PrinterModel'];
  $inkname = $row['InkName'];
  $cost = ($_POST['NowOnOrder'] * $row['Price']);
  $department = "NotApplicable";
  $note = "Stock Order";
  $detail = $_POST['NowOnOrder'] . ' On Order';
  if(isset($_GET['redirect'])){$redirect=$_GET['redirect'];}else {$redirect="";}
  }

?>

<script>
    window.setTimeout(function(){window.location.assign("<?php echo 'audit.php?utitle=addstock&printer=' . $printer . '&inkname=' . $inkname . '&cost=' . $cost . '&department=' . $department . '&detail=' . $detail . '&note=' . $note . '&redirect=' . $redirect; ?>")}, 500);
</script>

<?PHP
}
else {

$result = mysqli_query($con, "SELECT * FROM Stock WHERE `Stock`.`IID` = $index;");

while($row = mysqli_fetch_array($result))
  {
?>
<h1>Stock On Order?</h1>
<table>
<tr><td colspan="2">
<form method="post" action="">
<?PHP
$i = 50;
echo '<tr><td align="right" >Stock Name:</td><td>' . $row['InkName'] . '</td></tr>';
echo '<tr><td align="right" >Quantity:</td><td><input name="NowOnOrder" type="number" value="' . $row['OnOrder'] . '" /></td></tr>';
echo '<tr align="center"><td colspan="2"><input type="hidden" name="currentstock" value="' . $row['Stock'] . '"/>';
$cancelbutton = "";
if (isset($_GET['redirect'])){
$cancelbutton = '<input type="button" name="cancel" value="Cancel" onclick="window.location.assign(' . "'" . $_GET['redirect'] . "'" . ');" />';
}
else {
$cancelbutton = "";
}
echo $cancelbutton . '<input type="submit" name="submit" value="Update" /></td></tr></table>';
  }
?>

<?PHP } ?>


<!-- 
##################################################
################# Not Logged in ##################
##################################################
-->

<?PHP
 }
else { 
?>
you're not logged in!
<?PHP }?>
</center>
</body>
</html>