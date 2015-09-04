<?PHP
session_start();
require "config/config.php";
$index = $_GET['index'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

<title>Delete Existing Entry | Stock Manager | &copy; Robin Wright</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<link href='adminwhite.css' rel='stylesheet' type='text/css'>
<script type="text/javascript">
function popout(url){
var popup=window.open(url,"","width=700,height=480,scrollbars=yes,resizable=yes,addressbar=no")
}
</script>
</head>
<body>
<center>
<?PHP


if (isset($_GET['delete'])) {


$index = $_GET['index'];

$result = mysqli_query($con, "SELECT * FROM Stock INNER JOIN Printers ON Printers.PID=Stock.PID WHERE `Stock`.`IID` = $index;") or die ('Unable to execute query. '. mysqli_error($con));
$row = mysqli_fetch_array($result);
$printer = $row['PrinterMake'] . " " . $row['PrinterModel'];
$inkname = $row['InkName'];
$cost = $row['Price'];
$department = "NotApplicable";
$detail = 'Product Removed From System';
$note = "";

mysqli_query($con,"DELETE FROM `Stock` WHERE `Stock`.`IID` = $index;");


?>
<script>
    window.setTimeout(function(){window.location.assign("<?php echo 'audit.php?utitle=deletestock&printer=' . $printer . '&inkname=' . $inkname . '&cost=' . $cost . '&department=' . $department . '&detail=' . $detail . '&note=' . $note . '&redirect=' . $redirect; ?>")}, 10);
</script>
<?php


}

else {


?>


Are you sure that you want to delete <?php echo $_GET['stock']; ?>?

<form action="">
<input type="hidden" value="true" name="delete" />
<input type="hidden" value="<?php echo $_GET['index'] ?>" name="index" />
<input type="hidden" value="<?php echo $_GET['stock'] ?>" name="stock" />
<input type="button" class="Del" value="Yes" onclick="window.location='delete.php?index=<?php echo $_GET['index'];?>&delete=true&stock=<?php echo $_GET['stock'];?>';" />
<input type="button" class="Green" value="No" onclick="window.location='editstock.php?index=<?php echo $_GET['index'];?>';" />
</form>

<?PHP } ?>

</center>
</body>
</html>