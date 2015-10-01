<?PHP

require "../config/config.php";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link href='../adminwhite.css' rel='stylesheet' type='text/css'>
<title>Scan Stock In</title>
</head>
<body>
<center>
<?PHP 




if (isset($_POST['department'])){
$UPC = $_POST['UPC'];
$result = mysqli_query($con, "SELECT * FROM Stock INNER JOIN Printers ON Printers.PID=Stock.PID WHERE `Stock`.`UPC` = $UPC;") or die ('Unable to execute query. '. mysqli_error($con));
$row = mysqli_fetch_array($result);
$newvalue = ($row['Stock'] - 1);
mysqli_query($con,"UPDATE  `InkStock`.`Stock` SET  `Stock` = '$newvalue' WHERE  `Stock`.`UPC` =$UPC;");
$printer = $row['PrinterMake'] . " " . $row['PrinterModel'];
$inkname = $row['InkName'];
$cost = $row['Price'];
$department = $_POST['department'];
$detail = '1 removed, (' . ($row['Stock'] - 1) . ' remaining.)';
$note = "Replacement";
$AuditLength = $_POST['auditlength'] + 1;
$redirect = "scanout.php?auditlength=" . $AuditLength;
?>
<script>
    window.setTimeout(function(){window.location.assign("<?php echo 'audit.php?utitle=addstock&printer=' . $printer . '&inkname=' . $inkname . '&cost=' . $cost . '&department=' . $department . '&detail=' . $detail . '&note=' . $note . '&redirect=' . $redirect; ?>")}, 10);
</script>





<?php
}
else {
if (isset($_POST['UPC'])){
?>


<h1>Select room/department</h1>
<form action="" method="POST">
<?php
$rooms = mysqli_query($con, "SELECT * FROM `Departments` JOIN `Stock` ON `Departments`.PID=`Stock`.PID WHERE `Stock`.`UPC` =" . $_POST['UPC']);
  echo '<select name="department" id="department">';
  
  while($row2 = mysqli_fetch_array($rooms))
  {
	echo '<option value="' . $row2['Room'] . '">' . $row2['Room'] . '</option>';
  }
  echo '</select>';
  if (isset($_GET['auditlength'])){
$AuditLength = $_GET['auditlength'];
}
else {
$AuditLength = 0;
}
echo '<input type="hidden" name="auditlength" value="' . $AuditLength . '" />';
?>

<input type="hidden" name="UPC" value="<?PHP echo $_POST['UPC']; ?>" />
<br/>
<input type="submit" value="Update" />
</form>

<?PHP
}
else {
?>
<h1>Scan barcode to remove stock</h1>
<form method="POST" action="">
<input type="text" name="UPC" autofocus />
<?php
if (isset($_GET['auditlength'])){
$AuditLength = $_GET['auditlength'];
}
else {
$AuditLength = 0;
}
echo '<input type="hidden" name="auditlength" value="' . $AuditLength . '" />';
?>
</form>
<br/>
<table id="audit" class="display" cellpadding="5" celspacing="0" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td>Date Y-M-D</td><td>Time</td><td>Ink Name</td><td>Detail</td></tr>
</thead>
<tbody>
<?PHP
$inks = mysqli_query($con, "SELECT * 
FROM  `AuditTrail` 
WHERE  `Detail` LIKE '%removed%'
ORDER BY  `AID` DESC 
LIMIT 0 , $AuditLength");

while($row = mysqli_fetch_array($inks))
  {

  echo "<tr><td>" . $row['Date'] . "</td><td>" . $row['Time'] . "</td><td>" . $row['InkName'] . "</td><td>" . $row['Detail'] . "</td></tr>";
  }
?>
</tbody>
</table>










<?PHP
}
}
mysqli_close($con);
?>
</center>
</body>
</html>