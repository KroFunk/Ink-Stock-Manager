<?PHP
session_start();
require "../config/config.php";
if(isset($_GET['index'])){$index = $_GET['index'];}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link href='adminwhite.css' rel='stylesheet' type='text/css'>
<title>Add New Stock</title>
</head>
<body>
<center>
<?PHP
if (1 == 1) {


if (isset($_POST['submit'])) {
$ExplodePrinter = explode(":", $_POST['printer']);
$printer = $ExplodePrinter[1];
$PID = $ExplodePrinter[0];
$InkName = $_POST['ink'];
$Price = $_POST['price'];
$StockWarning = $_POST['stockwarning'];
$StockDefault = $_POST['stockdefault'];
$OrderURL = $_POST['orderurl'];
$UPC = $_POST['UPC'];

mysqli_query($con,"INSERT INTO  `InkStock`.`Stock` (
`PID` ,
`InkName` ,
`Price` ,
`Stock` ,
`StockWarning` ,
`StockDefault` ,
`OrderURL`, 
`OnOrder`, 
`UPC`
)
VALUES (
'$PID',  '$InkName',  '$Price',  '0',  '$StockWarning',  '$StockDefault',  '$OrderURL', '0', '$UPC'
);") or die ('Unable to execute query. '. mysqli_error($con));



echo $_POST['printer'] . " " . $_POST['ink'] . " has been created.<br />";
echo "Please wait....";
$department = "NotApplicable";
$note = "New Product Added to System";
?>
<script>
    window.setTimeout(function(){window.location.assign("<?php echo 'audit.php?utitle=addnew&printer=' . $printer . '&inkname=' . $InkName . '&cost=' . $Price . '&department=' . $department . '&redirect=addnew.php&detail=' . $note; ?>")}, 500);
</script>
<?PHP
}

else {





?>
<h1>Add a new Ink/Toner</h1>
<form method="post" action="">
<table id="example" class="display" cellpadding="5" celspacing="0" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td>Printer</td><td>Ink Name</td><td>Price</td><td>Stock Warning</td><td>Stock Default</td><td>OrderURL</td><td>Bar Code</td></tr>
</thead>
<tbody>
<?PHP
  echo "<tr style=''><td>"; 
  
  $printers = mysqli_query($con, "SELECT * FROM `Printers` LIMIT 0, 30 ");
  echo '<select name="printer">';
  while($row = mysqli_fetch_array($printers))
  {
  
echo '<option value="' . $row['PID'] . ":" . $row['PrinterMake'] . " " . $row['PrinterModel'] . '">' . $row['PrinterMake'] . " " . $row['PrinterModel'] . '</option>';


  }
  echo '</select>';
  echo "</td><td>" . '<input type="text" style="width:100%;" name="ink" value=""/>' . "</td><td>" . '<input type="text" style="width:100%;" name="price" value=""/>' . "</td><td>" . '<input type="number" style="width:100%;" name="stockwarning" value=""/>' . "</td><td>" . '<input type="number" style="width:100%;" name="stockdefault" value=""/>' . "</td><td>" . '<input type="text" style="width:100%;" name="orderurl" value=""/>' . "</td><td>" . '<input type="text" style="width:100%;" name="UPC" value=""/>' . "</td></tr>";
?>
</tbody>
</table>
<?php
echo '<input type="submit" name="submit" value="Create" />';
  
?>
</form>
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