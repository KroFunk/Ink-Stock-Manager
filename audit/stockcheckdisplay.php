<?PHP
session_start();
require "../config/config.php";
?>

<HTML>
<head>
<title>Stock Manager | Audit | &copy; Robin Wright 2014</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<link href='../admin.css' rel='stylesheet' type='text/css'>
<link href='../demo_table.css' rel='stylesheet' type='text/css'>
<script type="text/javascript">
function popout(url){
var popup=window.open(url,"Stock Manager Popup","width=700,height=650,scrollbars=1,resizable=1,addressbar=0")
}
</script>

<script>
function openwrapper(url){
document.getElementById('iframewrapper').style.display='block'; 
document.getElementById('grey').style.display='block';
 document.getElementById('Iframe').src = url;
}
</script>



<!--

<script>
$(document).ready( function () {
  $('#example').dataTable( {
    "columnDefs": [
    { "orderData": [ 0, 1 ],    "targets": 0 }
    ],
    "bPaginate": false
  } );
} );
</script>
-->

<script type="text/javascript" src="../incs/jquery.min.js"></script>

<script type="text/javascript" src="../incs/jquery.dataTables.nightly.js"></script>
<script>
$(document).ready(function() {
    $('#example').dataTable( {
    
     "order": [[ 0, "asc" ]],
    
	"bPaginate": false,
} );
} );
</script>



</head>
<body style="margin:0px; padding:0px;">



<?PHP



echo "<div id='menu'>";
include "../incs/menu.inc";
echo "</div>";


if (isset($_POST['I5'])) {
echo "old method, please use new add function.";
}

?>
<div class="main" onmouseover="Hide('ReportsMenu')" >
<!--
Server message would go here!
-->
<div>

<?php
$theDate = $_GET['date'];
$theTime = $_GET['time'] . ":00";

$result = mysqli_query($con, "SELECT * FROM `StockChecks` INNER JOIN Stock ON StockChecks.IID=Stock.IID INNER JOIN Printers ON Stock.PID=Printers.PID INNER JOIN users ON StockChecks.UserID=users.UserID WHERE `Date` = '$theDate' AND `Time` = '$theTime'") or die ('Unable to execute query. '. mysqli_error($con));
$row = mysqli_fetch_array($result);
?>

<div class='function'>
<a class="function refresh" href="javascript:location.reload();"><img src="../icns/refresh.png"/> Refresh!</a> 
</div>
<table id="example" class="display" cellpadding="5" celspacing="0" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td width="90px">Ink/Toner</td><td>Old Stock Amount</td><td>New Stock Amount</td></tr>
</thead>
<tfoot>
<tr>
<td colspan="3" align="right">
<?php 
echo "Stock Check by: " . $row['Name'] . " @ " . $row['Date'] . " " . $row['Time']; 
?>
</td>
</tr>
</tfoot>
<tbody>
<?PHP
while($row = mysqli_fetch_array($result))
  {

if ($row['OldStock'] != $row['NewStock']) {
  		$rowcss = "style='background:#f75b68;'";
  		}
  		else {
  		$rowcss = "";
  		}


	echo "<tr " . $rowcss . "><td align='left'>" . $row['PrinterMake'] . " " . $row['InkName'] . "</td><td align='center'>" . $row['OldStock'] . "</td><td align='center'>"  . $row['NewStock'] . "</td></tr>";

  }
?>
</tbody>
<tfoot>
<tr><td colspan="3">&nbsp;</td></tr>
</tfoot>
</table>
</div>
</div>

<?PHP
mysqli_close($con);
?>

<p style="margin:5px;padding:0px;clear:both;text-align:center;">&copy; Robin Wright 2014 </p>

<p style="margin:0px;padding:0px;clear:both;text-align:center;"></p>

</div>
</div>



<!--
###########################################################################
############################# Iframe Section ##############################
###########################################################################
-->


<div id="grey" style="background:#000; width:2000; height:2000; position:fixed; left:-5; top:-5; opacity:0.3; display:none;">&nbsp;</div>
<div id="iframewrapper" style="background-color: rgb(255, 255, 255); box-shadow: rgb(0, 0, 0) 0px 0px 20px; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom-right-radius: 10px; border-bottom-left-radius: 10px; position: fixed; z-index: 999999; width: 1000px; height: 500px; left: 50%; margin-left: -500px; top: 50%; margin-top: -250px; display: none; background-position: initial initial; background-repeat: initial initial;"><a href="javascript:void(0);" onclick="javascript:location.reload();">
<img src="../icns/X.png" style="position:relative; top:-10px; left:990px; border:0 none;"></a>

<div style="clear:both; padding:20px; padding-left:0px; margin-top:-50px;">

<iframe id="Iframe" style="margin:10px; height:490px; width:100%;" border="0" frameborder="0"></iframe>

</div>

</div>
 
     
</body>
</HTML>