<?PHP
session_start();
require "config/config.php";
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
while($row = mysqli_fetch_array($result))
  {
  
echo "Entry No: " . $index . "<br />";

$newvalue = $_POST['currentstock'] + $_POST['toadd'];

mysqli_query($con,"UPDATE  `InkStock`.`Stock` SET  `Stock` =  '$newvalue' WHERE  `Stock`.`IID` =$index;");

if (isset($_POST['offorder'])){
$NewOnOrder = $row['OnOrder'] - $_POST['toadd'];
if ($NewOnOrder <= 0) {
$NewOnOrder = 0;
}
mysqli_query($con,"UPDATE  `InkStock`.`Stock` SET  `OnOrder` =  '$NewOnOrder' WHERE  `Stock`.`IID` =$index;");
}

echo "Please Wait...";


  $printer = $row['PrinterMake'] . " " . $row['PrinterModel'];
  $inkname = $row['InkName'];
  $cost = ($_POST['toadd'] * $row['Price']);
  $department = "NotApplicable";
  $note = $_POST['note'];
  $detail = $_POST['toadd'] . ' added, (' . ($row['Stock'] + $_POST['toadd']) . ' in stock.)';
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
<h1>Add Stock</h1>
<table>
<tr><td colspan="2">
<form method="post" action="">
<?PHP
$i = 50;
echo "<center>" . $row['InkName'] . "</center>";
echo "</td></tr>";
echo '<tr><td align="right" >Quantity:</td><td><select name="toadd">';
$b = 1;
while($i > 0){
echo '<option value="' . $b . '">' . $b . '</option>';
$b = $b + 1;
$i = $i - 1;
}
echo '</select></td></tr>';
echo '<tr><td align="right" >Notes:</td><td><input type="text" cols="20" name="note" value="Stock delivery" /></td></tr>';
echo '<tr><td align="right" ></td><td><input type="checkbox" name="offorder" checked /> Deduct from "On Order"?</td></tr>';
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
you not logged in bro!
<?PHP }?>
</center>
</body>
</html>