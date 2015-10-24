<?PHP

require "../config/config.php";
?>

<HTML>
<head>
<title>Stock Manager | Admin | &copy; Robin Wright 2014</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<link href='../admin.css' rel='stylesheet' type='text/css'>
<link href='../demo_table.css' rel='stylesheet' type='text/css'>
<script type="text/javascript">
function popout(url){
var popup=window.open(url,"Stock Manager Popup","width=700,height=650,scrollbars=1,resizable=1,addressbar=0")
}
</script>

<script type="text/javascript" src="../incs/jquery.min.js"></script>
<script type="text/javascript" src="../incs/robins.iframe.wrapper.js"></script>
<script type="text/javascript" src="../incs/jquery.dataTables.nightly.js"></script>


<script>
$(document).ready(function() {
    $('#example').dataTable( {
    "columnDefs": [
    { "orderData": [ 0, 1 ],    "targets": 0 }
    ],
    "bPaginate": false,
} );
} );
</script>





</head>
<body style="margin:0px; padding:0px;">

<img src="../incs/blur.jpg" class="bg" />

<div class="tablescroll dataScreenOptimised" id="tablescroll" style="display:none;">
<table class="display" cellpadding="5" celspacing="0" width="100%" style="width:100%;">
<tr style='background-color:#666; color:#eee;'><td>Make/Model</td><td>Media</td><td>Colour</td><td>Type</td><td>Room - Department</td><td width="30px">Edit</td><td width="60px" >Support</td><td width="50px">History</td><td width="40px">Stock</td></tr>
</table>
</div>

<?PHP

include "../incs/menu.inc";

if (isset($_POST['I5'])) {
echo "old method, please use new add function.";
}

?>
<div class='HeaderBanner'>Printers <img src="../icns/question.png" /><div id="SubHeader" class='SubHeaderBanner'>Loading, please wait...</div></div>

<div class="main" onmouseover="Hide('ReportsMenu')" >
<!--
Server message would go here!
-->
<div>

<div class='function'>
<a class="function wrapper" href="javascript:openwrapper('addnew.php')"><img src="../icns/newprinter.png"/> Add New Printer</a>
<a class="function refresh" href="javascript:location.reload();"><img src="../icns/refresh.png"/> Refresh! </a>
<a class="function refresh" href="hidden.php"><img src="../icns/deleteprinter.png"/> View deleted printers</a>
</div>
<table id="example" class="display" cellpadding="5" celspacing="0" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td>Make/Model</td><td>Media</td><td>Colour</td><td>Type</td><td>Room - Department</td><td width="30px">Edit</td><td width="60px" >Support</td><td width="50px">History</td><td width="40px">Stock</td></tr>
</thead>
<tbody>
<?PHP
$style = 0;

$Printers = 0;
$Locations = 0;

$result = mysqli_query($con, "SELECT * FROM `printers` WHERE `Deleted` = 0;")or die ('Unable to execute query. '. mysqli_error($con));

while($row = mysqli_fetch_array($result))
  {
  
  if ($row['Colour'] == 1) {
  $colour = "Yes";
  }
  else {
  $colour = "no";
  }
  
  echo "<tr><td>" . $row['PrinterMake'] . " " . $row['PrinterModel'] . "</td><td>" . $row['Media'] . "</td><td>" . $colour . "</td><td>" . $row['Type'] . "</td><td>"; 
  $Printers ++;
  $PID = $row['PID'];
     
$rooms = mysqli_query($con, "SELECT * FROM `Departments` WHERE `Departments`.`PID` = $PID ORDER BY `Room` ASC;");
  //echo "<div style='max-height:20px; overflow:hidden;' onclick='this.style.overflow=" . '"initial"' . "; this.style.maxHeight=" . '"100%"' . "'>";
  while($room = mysqli_fetch_array($rooms))
  {
	echo $room['Room'] . ',<br/>';
	$Locations ++;
  }
  //echo "</div>";
    
    if ($row['SupportLink'] != ""){
    $supportLink = "<td><center><a href='" . $row['SupportLink'] . "' target='_new'><img src='../icns/support.png'/></a></center></td>";
    }
    else {
        $supportLink = "<td></td>";
    }
  
  echo "</td>
  <td><center><a href='" . 'javascript:openwrapper("editprinter.php?index=' .  $row['PID'] . '", 920, 400)' . "'><img src='../icns/edit.png'/></a></center></td>
" . $supportLink . "
  <td><center><a href='" . 'javascript:openwrapper("history.php?index=' .  $row['PID'] . '", 920, 580)' . "'><img src='../icns/audit.png'/></a></center></td>
  <td><center><a href='" . 'javascript:openwrapper("stock.php?index=' .  $row['PID'] . '", 920, 380)' . "'><img src='../icns/open.png'/></a></center></td>

  </tr>";
$style = $style + 1;
  }
?>
</tbody>
<tfoot>
<tr><td colspan="5">&nbsp;</td></tr>
</tfoot>
</table>


<?php echo 
"<script>
window.onload = function(updatesubheader) {
document.getElementById('SubHeader').innerHTML = '$Printers printers in $Locations locations.';
}
</script>"
?>


</div>
</div>

<?PHP
mysqli_close($con);
?>


<div class="footerfill"></div>

<?php include "../incs/footer.inc"; ?>

<p style="margin:0px;padding:0px;clear:both;text-align:center;"></p>

</div>
</div>


<!--
###########################################################################
######################### Iframe Section  Start ###########################
###########################################################################
-->

<!-- Grey out background -->
<div id="grey" style="display:none;" onclick="closewrapper();">&nbsp;</div>

<!-- The white box that the window will reside in -->
<div id="iframewrapper" style="width: 750px; height: 230px; margin-left: -375px; margin-top: -95px; display: none;">

<!-- The 'X' button -->
<a href="javascript:void(0);" onclick="closewrapper();">
<img id="iframeX" src="../icns/X.png" style="position:relative; top:-5px; left:735px; border:0 none;">
</a>

<!-- Actual iFrame container -->
<div style="clear:both; padding:20px; padding-left:0px; margin-top:-50px;">
<iframe id="Iframe" style="margin:10px; height:220px; width:100%;" border="0" frameborder="0"></iframe>
</div>

</div>
 
<!--
###########################################################################
########################## Iframe Section  End ############################
###########################################################################
-->
 
     
</body>
</HTML>