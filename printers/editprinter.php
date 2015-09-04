<?PHP
session_start();
require "../config/config.php";
$index = $_GET['index'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link href='../adminwhite.css' rel='stylesheet' type='text/css'>
<title>Edit Printer</title>
</head>
<body>
<center>
<?PHP
if (isset($_GET['index'])) {


if (isset($_POST['submit'])) {



$printermake = $_POST['printermake'];
$printermodel = $_POST['printermodel'];
$colour = $_POST['colour'];
$media = $_POST['media'];
$type = $_POST['type'];
$supportlink = $_POST['supportlink'];

mysqli_query($con,"UPDATE  `InkStock`.`Printers` SET  `PrinterMake` =  '$printermake', `PrinterModel` =  '$printermodel', `SupportLink` =  '$supportlink', `Colour` =  '$colour', `Type` =  '$type', `Media` =  '$media' WHERE  `Printers`.`PID` =$index;");



echo "Changes to " . $_POST['printer'] . " " . $_POST['ink'] . " complete.<br />";
echo "Please Wait...";
?>

<script>
setTimeout(function(){window.location.href='editprinter.php?index=<?PHP echo $index; ?>'}, 1500);
</script>

<?PHP
}

else {




$result = mysqli_query($con, "SELECT * FROM Printers WHERE `Printers`.`PID` = $index;");

while($row = mysqli_fetch_array($result))
  {
?>
<h1>Edit <?php echo $row['PrinterMake'] . " " . $row['PrinterModel']; ?></h1>
</center>
<h3 style="text-align:left;">General</h3>
<form method="post" action="">
<table id="example" class="display" cellpadding="5" celspacing="0" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td>Manufacturer</td><td>Model</td><td>Colour</td><td>Media</td><td>Type</td><td>Support URL</td></tr>
</thead>
<tbody>
<?PHP
  echo "<tr style=''>";
	echo '<td><input type="text" style="width:98%;" name="printermake" value="' . $row['PrinterMake'] . '"/>' . "</td>";   
	echo '<td><input type="text" style="width:98%;" name="printermodel" value="' . $row['PrinterModel'] . '"/>' . "</td>"; ?>

<?PHP
$ColourSelected = "";
$NotColourSelected = "";
if ($row['Colour'] == 1){
$ColourSelected = "Selected";
}
else {
$NotColourSelected = "Selected";
}
?>  
    <td>
    <select style="width:60px;" name="colour">
    <option <?PHP echo $ColourSelected; ?> value="1">Yes</option>
    <option <?PHP echo $NotColourSelected; ?> value="0">No</option>
    </select>
    </td> 
    
    <?PHP
    echo '<td><input type="text" style="width:60px;" name="media" value="' . $row['Media'] . '"/>' . "</td>";
    
$LaserSelected = "";
$InkjetSelected = "";
$OtherSelected = "";
if ($row['Type'] == 'Laser'){
$LaserSelected = "Selected";
}
else if ($row['Type'] == 'Inkjet') {
$InkjetSelected = "Selected";
}
else {
$OtherSelected = "Selected";
}
?>  
    <td>
    <select style="width:60px;" name="type">
    <option <?PHP echo $LaserSelected; ?> value="Laser">Laser</option>
    <option <?PHP echo $InkjetSelected; ?> value="Inkjet">Inkjet</option>
    <option <?PHP echo $OtherSelected; ?> value="Other">Other</option>
    </select>
    </td> 
    
    
    <?PHP
    echo '<td><input type="text" style="width:98%;" name="supportlink" value="' . $row['SupportLink'] . '"/>' . "</td>"; 
   echo "</tr>";
?>
</tbody>
</table>
<?php
echo '<center><input type="button" class="Del" value="Delete" onclick="document.location.href=' . "'" . "deleteprinter.php?index=" . $_GET['index'] . "&printer=" . $row['PrinterMake'] . " " . $row['PrinterModel'] . "'" . '" /> <input type="submit" name="submit" value="Update" /></center>';
  }
?>
</form>


<h3 style="text-align:left;">Rooms - Departments</h3>
<table id="example2" class="display" cellpadding="5" celspacing="0" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td>Current (list)</td><td>Add New Room - Department</td></tr>
</thead>
<tbody>
<?PHP
  echo "<tr style=''>";
	echo '<td>';
	
	
	$rooms = mysqli_query($con, "SELECT * FROM `Departments` WHERE `Departments`.`PID` = $index;");
  echo '<select name="currentrooms" id="currentrooms">';
  
  while($row = mysqli_fetch_array($rooms))
  {
	echo '<option value="' . $row['DID'] . '">' . $row['Room'] . '</option>';
  }
  echo '</select>';
	
	echo "&nbsp;<a href='#' onclick=" . '"window.location.href =' . "'deleteroom.php?DID='" . " + document.getElementById('currentrooms').value;" . '"' . "><img style='vertical-align:middle;' src='../icns/delete.png'/></a>";
	
	echo "</td>";   
	
	echo '<td><form action="newroom.php" method="get"><input type="hidden" value="' . $index . '" name="pid"><input type="text" style="width:65%;" name="room" value=""/><input  type="submit" name="addroom" value="Add Room" />' . "</td>"; 
  echo "</tr>";
?>
</tbody>
</table>


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

</body>
</html>