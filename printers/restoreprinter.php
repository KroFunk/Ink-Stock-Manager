<?PHP
session_start();
require "../config/config.php";
$index = $_GET['index'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

<title>Restore hidden printer | Stock Manager | &copy; Robin Wright</title>
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


mysqli_query($con,"UPDATE `inkstock`.`printers` SET `Deleted` = '0' WHERE `printers`.`PID` = $index;");



echo $_GET['printer'] . " has been restored! <br/>...Please wait...";

echo "<script>
    setTimeout(function(){ parent.reloadparent(); }, 1200);
</script>";


}

else {


?>


<h2>Are you sure that you want to restore <?php echo $_GET['printer']; ?>?</h2>

<p>The entry will become visible in the Ink Stock Manager's interface. </p>

<form action="">
<input type="hidden" value="restore" name="I5" />
<input type="hidden" value="<?php echo $_GET['index'] ?>" name="index" />
<input type="hidden" value="<?php echo $_GET['printer'] ?>" name="printer" />
<input type="button" value="Cancel" onclick="parent.closewrapper();" />
<input type="button" class="Del" value="Continue" onclick="window.location='restoreprinter.php?index=<?php echo $_GET['index'];?>&I5=true&printer=<?php echo $_GET['printer'];?>';" />
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