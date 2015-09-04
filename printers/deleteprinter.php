<?PHP
session_start();
require "../config/config.php";
$index = $_GET['index'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

<title>Delete Existing Entry | Stock Manager | &copy; Robin Wright</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<link href='../adminwhite.css' rel='stylesheet' type='text/css'>
<script type="text/javascript">
function popout(url){
var popup=window.open(url,"","width=700,height=480,scrollbars=yes,resizable=yes,addressbar=no")
}
</script>
</head>
<body>
<center>
<?PHP
if (isset($_GET['I5'])) {


$index = $_GET['index'];


mysqli_query($con,"UPDATE `inkstock`.`printers` SET `Deleted` = '1' WHERE `printers`.`PID` = $index;");



echo $_GET['printer'] . " has been deleted! <br/>...Please wait...";
echo "<script>
    setTimeout(function(){ parent.reloadparent(); }, 1200);
</script>";
}

else {


?>


<h2>Are you sure that you want to delete <?php echo $_GET['printer']; ?>?</h2>

<p>The entry will be hidden from the Ink Stock Manager's interface, but it will still be present in the database. 
This is for historical reports and stock that may still be present. You can either restore the printer or drop 
it from the database completely after this step has been completed. </p>

<form action="">
<input type="hidden" value="delete" name="I5" />
<input type="hidden" value="<?php echo $_GET['index'] ?>" name="index" />
<input type="hidden" value="<?php echo $_GET['printer'] ?>" name="printer" />
<input type="button" value="Cancel" onclick="window.location='editprinter.php?index=<?php echo $_GET['index'];?>';" />
<input type="button" class="Del" value="Continue" onclick="window.location='deleteprinter.php?index=<?php echo $_GET['index'];?>&I5=true&printer=<?php echo $_GET['printer'];?>';" />
</form>

<?PHP } ?>


<!-- 
##################################################
################# Not Logged in ##################
##################################################
-->
</center>
</body>
</html>