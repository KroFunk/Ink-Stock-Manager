<?PHP

require "../config/config.php";
if(isset($_GET['index'])){$index = $_GET['index'];}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link href='../adminwhite.css' rel='stylesheet' type='text/css'>
<title>Add New Printer</title>
</head>
<body>
<center>
<?PHP

if (isset($_POST['submit'])) {

$printermake = $_POST['printermake'];
$printermodel = $_POST['printermodel'];
$colour = $_POST['colour'];
$type = $_POST['type'];
$media = $_POST['media'];
$support = $_POST['support'];

mysqli_query($con,"INSERT INTO  `InkStock`.`Printers` (
`PrinterMake` ,
`PrinterModel` ,
`SupportLink` ,
`colour` ,
`Type` ,
`media`
)
VALUES (
'$printermake',  '$printermodel',  '$support',  '$colour',  '$type',  '$media'
);");



echo $printermake . " " . $printermodel . " has been created.<br />";
echo "You may now close this window.";
}
else {
?>
<h1>Add a new Printer</h1>

<form method="post" action="">
<table id="example" class="display" cellpadding="5" celspacing="0" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td>Manufacturer</td><td>Model</td><td>Colour</td><td>Media</td><td>Type</td><td>Support URL</td></tr>
</thead>
<tbody>
<?PHP
  echo "<tr style=''>";
	echo '<td><input type="text" style="width:98%;" name="printermake" value=""/>' . "</td>";   
	echo '<td><input type="text" style="width:98%;" name="printermodel" value=""/>' . "</td>"; ?>

    <td>
    <select style="width:60px;" name="colour">
    <option value="1">Yes</option>
    <option value="0">No</option>
    </select>
    </td> 
    <?PHP
    echo '<td><input type="text" style="width:60px;" name="media" value=""/>' . "</td>";?>  
    <td>
    <select style="width:60px;" name="type">
    <option value="Laser">Laser</option>
    <option value="Inkjet">Inkjet</option>
    <option value="Other">Other</option>
    </select>
    </td> 
    
    
    <?PHP
    echo '<td><input type="text" style="width:98%;" name="supportlink" value=""/>' . "</td>"; 
   echo "</tr>";
?>
</tbody>
</table>
<?php
echo '<center><input type="submit" name="submit" value="Create" /></center>';
?>
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