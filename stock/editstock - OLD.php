<?PHP

require "../config/config.php";
$index = $_GET['index'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link href='../../adminwhite.css' rel='stylesheet' type='text/css'>
<title>Edit Stock</title>
</head>
<body>
<center>
<?PHP
if (isset($_GET['index'])) {


if (isset($_POST['submit'])) {

$MakeModel = $_POST['printer'];
$InkName = $_POST['ink'];
$Price = $_POST['price'];
$StockWarning = $_POST['stockwarning'];
$StockDefault = $_POST['stockdefault'];
$OrderURL = $_POST['orderurl'];
$BarCode = $_POST['barcode'];
$ProductCode = $_POST['productcode'];
$Description = $_POST['description'];

mysqli_query($con,"UPDATE  `InkStock`.`Stock` SET  `PID` =  '$MakeModel', `InkName` =  '$InkName', `Price` =  '$Price', `StockWarning` =  '$StockWarning', `StockDefault` =  '$StockDefault', `OrderURL` =  '$OrderURL', `ProductCode` = '$ProductCode', `Description` = '$Description', `UPC` =  '$BarCode' WHERE  `Stock`.`IID` =$index;") or die ('Unable to execute query. '. mysqli_error($con));;

echo "Changes to " . $_POST['ink'] . " complete.<br />";
echo "You may now close this window";
}

else {

$result = mysqli_query($con, "SELECT * FROM Stock INNER JOIN printers ON `stock`.`PID`=`printers`.`PID` WHERE `Stock`.`IID` = $index;") or die ('Unable to execute query. '. mysqli_error($con));;

while($row = mysqli_fetch_array($result))
  {
?>
<h1>Edit <?php echo $row['InkName']; ?></h1>
<form method="post" action="">
<table id="example" class="display" cellpadding="5" celspacing="0" style="width:100%;">
<thead>
</thead>
<tbody>
<tr style='background-color:#666; color:#eee;'><td>Printer</td><td>Ink Name</td><td>Stock Warning</td><td>Stock Default</td><td>Bar Code</td></tr>
<?PHP
  echo "<tr style=''><td>";  
  echo '<select name="printer">';
  echo '<option value="' . $row['PID'] . '">' . $row['PrinterMake'] . " " . $row['PrinterModel'] . ' (current)</option>';
  
  $printers = mysqli_query($con, "SELECT * FROM `Printers` LIMIT 0, 30 ") or die ('Unable to execute query. '. mysqli_error($con));;
  while($printerrow = mysqli_fetch_array($printers))
  {
	echo '<option value="' . $printerrow['PID'] . '">' . $printerrow['PrinterMake'] . " " . $printerrow['PrinterModel'] . '</option>';
  }
  echo '</select>';
   
   
   echo "</td><td>" . '<input type="text" style="width:96%;" name="ink" value="' . $row['InkName'] . '"/>' . "</td><td>" . '<input type="number" style="width:96%" name="stockwarning" value="' . $row['StockWarning'] . '"/>' . "</td><td>" . '<input type="number" style="width:96%;" name="stockdefault" value="' . $row['StockDefault'] . '"/>' . "</td><td>" . '<input type="text" style="width:96%;" name="barcode" value="' . $row['UPC'] . '"/>' . "</td></tr>";
?>

<table id="example" class="display" cellpadding="5" celspacing="0" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td>Product Code</td><td>Description</td><td>Price</td><td>OrderURL</td></tr>
</thead>
<tbody>
<?PHP
   echo "<tr style=''><td>" . '<input type="text" style="width:96%" name="productcode" value="' . $row['ProductCode'] . '"/>' . "</td><td>" . '<input type="text" style="width:96%" name="description" value="' . $row['Description'] . '"/>' . "</td><td>" . '<input type="text" style="width:96%" name="price" value="' . $row['Price'] . '"/>' . "</td><td>" . '<input type="text" style="width:96%;" name="orderurl" value="' . $row['OrderURL'] . '"/>' . "</td></tr>";
?>
</tbody>
</table>




<?php
echo '<input type="button" class="Del" name="Delete" value="Delete" onclick="document.location.href=' . "'" . "delete.php?index=" . $_GET['index'] . "&stock=" . $printerrow['PrinterMake'] . " " . $printerrow['PrinterModel'] . " " . $row['InkName'] . "'" . ';" /><input type="submit" name="submit" value="Update" />';
  }
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