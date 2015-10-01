<?PHP

require "../config/config.php";
$redirect = "&redirect=/ink/printers/view.php?index=" . $_GET['index'];
?>

<HTML>
<head>
<title>Stock Manager | Admin | &copy; Robin Wright 2014</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<link href='../adminwhite.css' rel='stylesheet' type='text/css'>
<link href='../demo_table.css' rel='stylesheet' type='text/css'>

<script>
function openwrapper(url){
document.getElementById('iframewrapper').style.display='block'; 
document.getElementById('grey').style.display='block';
 document.getElementById('Iframe').src = url;
}
</script>








<script type="text/javascript" src="../incs/jquery.min.js"></script>

<script type="text/javascript" src="../incs/jquery.dataTables.nightly.js"></script>


<script>
$(document).ready( function () {
  $('#example').dataTable( {
    "columnDefs": [
    { "orderData": [ 0, 1 ],    "targets": 0 }
    ],
    "bPaginate": false,
    "bInfo": false,
  } );
} );
</script>
<script>
$(document).ready( function () {
  $('#audit').dataTable( {
    "columnDefs": [
    { "orderData": [ 0, 1 ],    "targets": 0 }
    ],
    "bPaginate": false,
    "bInfo": false,
  } );
} );
</script>


<script>
function openwrapper(url){
window.location.assign(url)
}
</script>
</head>
<body style="margin:0px; padding:0px;">



<?PHP

if (isset($_POST['I5'])) {
echo "old method, please use new add function.";
}

?>
<div class="notmain">
<!--
Server message would go here!
-->
<div>



<?PHP
$PID = $_GET['index'];
$result = mysqli_query($con, "SELECT * FROM `Printers` WHERE `PID` = $PID") or die ('Unable to execute query. '. mysqli_error($con));

$row = mysqli_fetch_array($result);
  echo "<h1>15 Most recent actions for " . $row['PrinterMake'] . " " . $row['PrinterModel'] . "</h1>";
   $ThisPrinter = $row['PrinterMake'] . " " . $row['PrinterModel'];
?>
<table id="audit" class="display" cellpadding="5" celspacing="0" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td>Date Y-M-D</td><td>Time</td><td>Ink Name</td><td>Cost</td><td>Department</td><td>Detail</td><td>Note</td></tr>
</thead>
<tbody>
<?PHP
$style = 0;
$inks = mysqli_query($con, "SELECT * 
FROM  `AuditTrail` 
WHERE  `Printer` =  '$ThisPrinter'
ORDER BY  `AID` DESC 
LIMIT 0 , 15") or die ('Unable to execute query. '. mysqli_error($con));

while($row = mysqli_fetch_array($inks))
  {

  echo "<tr><td>" . $row['Date'] . "</td><td>" . $row['Time'] . "</td><td>" . $row['InkName'] . "</td><td>&pound;" . $row['Cost'] . "</td><td>" . $row['Department'] . "</td><td>" . $row['Detail'] . "</td><td>" . $row['Note'] . "</td></tr>";
$style = $style + 1;
  }
?>
</tbody>
</table>



</div>
</div>

<?PHP
mysqli_close($con);
?>

<p style="margin:0px;padding:0px;clear:both;text-align:center;"></p>

</div>
</div>



<!--
###########################################################################
############################# Iframe Section ##############################
###########################################################################
-->


<div id="grey" style="background:#000; width:2000; height:2000; position:fixed; left:-5; top:-5; opacity:0.3; display:none;">&nbsp;</div>
<div id="iframewrapper" style="background-color: rgb(255, 255, 255); box-shadow: rgb(0, 0, 0) 0px 0px 20px; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom-right-radius: 10px; border-bottom-left-radius: 10px; position: fixed; z-index: 999999; width: 1000px; height: 500px; left: 50%; margin-left: -500px; top: 50%; margin-top: -250px; display: none; background-position: initial initial; background-repeat: initial initial;"><a href="javascript:void(0);" onclick="javascript:location.reload();"><img src="../icns/X.png" style="position:relative; top:-5px; left:990px; border:0 none;"></a>

<div style="clear:both; padding:20px; padding-left:0px; margin-top:-50px;">

<iframe id="Iframe" style="margin:10px; height:490px; width:100%;" border="0" frameborder="0"></iframe>

</div>

</div>
 
     
</body>
</HTML>