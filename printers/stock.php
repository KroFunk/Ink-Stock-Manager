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
  
  echo "<h1>Stock for " . $row['PrinterMake'] . " " . $row['PrinterModel'] . "</h1>";
   $ThisPrinter = $row['PrinterMake'] . " " . $row['PrinterModel'];
 ?>

<div class='function'>
<a class="function wrapper" href="javascript:openwrapper('../addnew.php?redirect=<?php echo $redirect;?>')"><img src="../icns/new.png"/> Add New Ink/Toner</a>
</div>
<table id="example" class="display" cellpadding="5" celspacing="0" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td>Ink Name</td><td>Price</td><td>Stock</td><td>Value</td><td width="35px">Edit</td><td width="35px">Order</td><td width="55px">Update</td></tr>
</thead>
<tbody>
<?PHP
$style = 0;
$inks = mysqli_query($con, "SELECT * 
FROM  `Stock` 
WHERE  `PID` =  '$PID'
LIMIT 0 , 99") or die ('Unable to execute query. '. mysqli_error($con));

while($row = mysqli_fetch_array($inks))
  {
  if($row['Stock'] <= $row['StockWarning']){
  $bg = "#f75b68";
  }
  else{ 
$bg = "";
}

if($row['OrderURL'] == "")
{
$order = "";
}
else{
$order = "<a href='" . 'javascript:popout("' . $row['OrderURL'] . '")' .  "' target='_new'><img src='../icns/order.png'/></a>";
}
  echo "<tr style='background:$bg;'><td>" . $row['InkName'] . "</td><td>&pound;" . $row['Price'] . "</td><td>" . $row['Stock'] . "</td><td>&pound;" . $row['Price']*$row['Stock'] . "</td><td><center><a href='" . 'javascript:openwrapper("../editstock.php?index=' . $row['IID'] . $redirect .'")' . "'><img src='../icns/edit.png'/></a></center></td><td><center>" . $order . "</center></td><td><center><a href='" . 'javascript:openwrapper("../addstock.php?index=' . $row['IID'] . $redirect . '")' . "'><img src='../icns/plus.png'/></a>&nbsp;&nbsp;<a href='" . 'javascript:openwrapper("../removestock.php?index=' . $row['IID'] . $redirect . '")' . "'><img src='../icns/minus.png'/></a></center></td></tr>";
$style = $style + 1;
  }
?>
</tbody>
</table>

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
<div id="iframewrapper" style="background-color: rgb(255, 255, 255); box-shadow: rgb(0, 0, 0) 0px 0px 20px; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom-right-radius: 10px; border-bottom-left-radius: 10px; position: fixed; z-index: 999999; width: 1000px; height: 500px; left: 50%; margin-left: -500px; top: 50%; margin-top: -250px; display: none; background-position: initial initial; background-repeat: initial initial;"><a href="javascript:void(0);" onclick="javascript:location.reload();"><img src="../icns/X.png" style="position:relative; top:-10px; left:990px; border:0 none;"></a>

<div style="clear:both; padding:20px; padding-left:0px; margin-top:-50px;">

<iframe id="Iframe" style="margin:10px; height:490px; width:100%;" border="0" frameborder="0"></iframe>

</div>

</div>
 
     
</body>
</HTML>