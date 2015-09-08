<?PHP

require "config/config.php";
$index = $_GET['index'];
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

$result = mysqli_query($con, "SELECT * FROM `Stock`\n" . "ORDER BY `Stock`.`IID` DESC LIMIT 0, 1 ");
if (!$check1_res) {
    printf("%s\n", mysqli_error($con));
}

//$index = mysqli_num_rows($result) + 1;
$row = mysqli_fetch_array($result);
$IID = $row['IID'] + 1;

$MakeModel = $_POST['printer'];
$InkName = $_POST['ink'];
$Price = $_POST['price'];
$StockWarning = $_POST['stockwarning'];
$StockDefault = $_POST['stockdefault'];
$OrderURL = $_POST['orderurl'];

mysqli_query($con,"INSERT INTO  `InkStock`.`Stock` (
`IID` ,
`MakeModel` ,
`InkName` ,
`Price` ,
`Stock` ,
`StockWarning` ,
`StockDefault` ,
`OrderURL`
)
VALUES (
'$IID',  '$MakeModel',  '$InkName',  '$Price',  '0',  '$StockWarning',  '$StockDefault',  '$OrderURL'
);");



echo $_POST['printer'] . " " . $_POST['ink'] . " has been created.<br />";
echo "You may now close this window";
}

else {





?>
<h1>Add a new Ink/Toner</h1>
<form method="post" action="">
<table id="example" class="display" cellpadding="5" celspacing="0" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td>Printer</td><td>Ink Name</td><td>Price</td><td>Stock Warning</td><td>Stock Default</td><td>OrderURL</td></tr>
</thead>
<tbody>
<tr style='background-color:$bgs'>
<td><input type="text" style="width:100%;" name="printer" value="" /></td>
<td><input type="text" style="width:100%;" name="ink" value=""/></td>
<td><input type="text" style="width:100%;" name="price" value=""/></td>
<td><input type="text" style="width:100%;" name="stockwarning" value=""/></td>
<td><input type="text" style="width:100%;" name="stockdefault" value=""/></td>
<td><input type="text" style="width:100%;" name="orderurl" value=""/></td>
</tr>
</tbody>
</table>
<input type="submit" name="submit" value="Create" />
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