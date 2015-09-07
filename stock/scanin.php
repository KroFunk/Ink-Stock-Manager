<?PHP
session_start();
require "../config/config.php";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link href='adminwhite.css' rel='stylesheet' type='text/css'>
<title>Scan Stock In</title>
</head>
<body>
<center>
<?PHP 
if (isset($_POST['UPC'])){
$UPC = $_POST['UPC'];
$result = mysqli_query($con, "SELECT * FROM Stock INNER JOIN Printers ON Printers.PID=Stock.PID WHERE `Stock`.`UPC` = $UPC;") or die ('Unable to execute query. '. mysqli_error($con));
$row = mysqli_fetch_array($result);
$newvalue = ($row['Stock'] + 1);
mysqli_query($con,"UPDATE  `InkStock`.`Stock` SET  `Stock` = '$newvalue' WHERE  `Stock`.`UPC` =$UPC;");
$printer = $row['PrinterMake'] . " " . $row['PrinterModel'];
$inkname = $row['InkName'];
$cost = $row['Price'];
$department = "NotApplicable";
$detail = '1 added, (' . ($row['Stock'] + 1) . ' in stock.)';
$note = "Stock delivery";
$AuditLength = $_POST['auditlength'] + 1;
$redirect = "scanin.php?auditlength=" . $AuditLength;

if (isset($_POST['offorder'])){
$NewOnOrder = $row['OnOrder'] - 1;
if ($NewOnOrder <= 0) {
$NewOnOrder = 0;
$redirect .= "&offorder=1";
}
mysqli_query($con,"UPDATE  `InkStock`.`Stock` SET  `OnOrder` =  '$NewOnOrder' WHERE `Stock`.`UPC` = $UPC;");
}
else {
$redirect .= "&offorder=0";
}
?>
<script>
    window.setTimeout(function(){window.location.assign("<?php echo 'audit.php?utitle=addstock&printer=' . $printer . '&inkname=' . $inkname . '&cost=' . $cost . '&department=' . $department . '&detail=' . $detail . '&note=' . $note . '&redirect=' . $redirect; ?>")}, 10);
</script>
<?php
}
else {
?>
<h1>Scan barcode to add stock</h1>
<form method="POST" action="">
<input type="text" name="UPC" autofocus /><br/>
<?php 
if (isset($_GET['offorder']) && $_GET['offorder'] == 0){
echo '<input type="checkbox" name="offorder" /> Deduct from "On Order"?';
}
else {
echo '<input type="checkbox" name="offorder" checked /> Deduct from "On Order"?';
}
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
WHERE  `Detail` LIKE '%added%'
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
mysqli_close($con);
?>
</center>
</body>
</html>