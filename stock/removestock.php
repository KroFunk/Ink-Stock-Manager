<?PHP
session_start();
require "../config/config.php";
$index = $_GET['index'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link href='adminwhite.css' rel='stylesheet' type='text/css'>
<title>Remove Stock</title>
</head>
<body>
<center>
<?PHP
if (isset($_GET['index'])) {


if (isset($_POST['submit'])) {



$newvalue = $_POST['currentstock'] - $_POST['totake'];

mysqli_query($con,"UPDATE  `InkStock`.`Stock` SET  `Stock` = '$newvalue' WHERE `Stock`.`IID` =$index;");


echo $newvalue . " " . $_POST['makemodel'] . " remaining.<br />";
echo "You may now close this window";
$result = mysqli_query($con, "SELECT * FROM Stock INNER JOIN Printers ON Printers.PID=Stock.PID WHERE `Stock`.`IID` = $index;");
while($row = mysqli_fetch_array($result))
  {
  $printer = $row['PrinterMake'] . " " . $row['PrinterModel'];
  $inkname = $row['InkName'];
  $cost = ($_POST['totake'] * $row['Price']);
  $department = $_POST['department'];
  $note = $_POST['note'];
  $detail = $_POST['totake'] . ' removed, (' . $newvalue . ' remaining.)';
    if(isset($_GET['redirect'])){$redirect=$_GET['redirect'];}else {$redirect="";}
  }
?>
<script>
    window.setTimeout(function(){window.location.assign("<?php echo 'audit.php?utitle=addstock&printer=' . $printer . '&inkname=' . $inkname . '&cost=' . $cost . '&department=' . $department . '&detail=' . $detail . '&note=' . $note . '&redirect=' . $redirect; ?>")}, 500);
</script>
<?PHP
}
else {

$result = mysqli_query($con, "SELECT * FROM Stock  INNER JOIN Printers ON Printers.PID=Stock.PID WHERE `Stock`.`IID` = $index;");

while($row = mysqli_fetch_array($result))
  {
?>
<h1>Remove Stock</h1>
<form method="post" action="">
<?php echo $row['InkName'];?>
<table>
<tr>
<?PHP
$i = $row['Stock'];
echo '<td align="right">Quantity:</td>';
echo '<td><select name="totake">';
$b = 1;
while($i > 0){
echo '<option value="' . $b . '">' . $b . '</option>';
$b = $b + 1;
$i = $i - 1;
}
echo '</select></td></tr>';
echo '<tr><td align="right" >Department:</td><td>';


	$rooms = mysqli_query($con, "SELECT * FROM `Departments` WHERE `Departments`.`PID` =" . $row['PID']);
  echo '<select name="department" id="department">';
  
  while($row2 = mysqli_fetch_array($rooms))
  {
	echo '<option value="' . $row2['Room'] . '">' . $row2['Room'] . '</option>';
  }
  echo '</select>';

  

echo '</td></tr>';
echo '<tr><td align="right" >Notes:</td><td><input type="text" cols="20" name="note" value="Replacement" /></td></tr>';
echo '<tr ><td align="center" colspan="2"><input type="hidden" name="currentstock" value="' . $row['Stock'] . '"/>';
echo '<input type="hidden" name="makemodel" value="' . $row['InkName'] . '"/>';
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