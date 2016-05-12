<?PHP
session_start();
require "../config/config.php";
if(isset($_GET['index'])){$index = $_GET['index'];}


if (isset($_POST['logname'])) { 
  
mysqli_query($con, "Delete FROM `pcounter` WHERE `LogFileName` = '".$_POST['logname']."'") or die ('Unable to execute query. '. mysqli_error($con));

    
    echo "<div style='text-align:center;color:white;background:#1F1F1F;'><b>" . $_POST['logname'] . " has been deleted! You may now close this window.</b></div>";
}


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link href='../adminwhite.css' rel='stylesheet' type='text/css'>
<title>Delete Log Data</title>
</head>
<body>
<center>

<h1>Delete Log Data</h1>
<?php if (!empty($_GET['success'])) { ?>
<div id="notify" style="opacity:0; position:absolute; top:5px; left:50%; width:230px; margin-left:-115px; font-size:12px; border:red 1px solid; background:yellow; padding:5px; text-align:center;">
Your log has been imported successfully.
</div>
<?php } ?>

<div id="target">
<p style='text-align:left;'>Use this form to delete PCounter Log Data. <br/><b>Note:</b> It may take some time, depending on the size of the log and server load. <br/><i>During this time the webpage may seem unresponsive.</i></p>

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
<table style="border:none;">
<tr><td>Log File</td><td style="border:none;"></td></tr>
<tr>
<td>
  
  <select name='logname' id='logname'>
<?php
$query=mysqli_query($con, "SELECT `LogFileName` FROM `pcounter` GROUP BY `LogFileName`") or die ('Unable to execute query. '. mysqli_error($con));
while($row = mysqli_fetch_array($query)){
  echo "<option value='" . $row['LogFileName'] . "'>" . $row['LogFileName'] . "</option>"; 
}
?>
</select>


</td>
<td></td></tr></table>
<input type="button" class="button" onclick="parent.closewrapper();" name="" value="Cancel">
<input type="button" onclick="importcsv()" name="Delete" class="delete" value="Delete" />
</form> 
</div>
<script>
form=document.getElementById("form1");
target=document.getElementById("target");
var timeout;
function importcsv() {
target.innerHTML = "<center><img src='moss.gif' style='padding:5px;' /><br/><div class='spinner'></div>Working, Please Wait.</center><br/>";
timeout = window.setTimeout(submitform,200);
}
function submitform() {
form.submit();
}
</script>
</center>
</body>
</html>