<?PHP

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
function updatequery(){
window.location.assign('/ink/audit/?fromdate=' + document.getElementById("fromdate").value + '&todate=' + document.getElementById("todate").value);
}
</script>

<script type="text/javascript" src="../incs/robins.iframe.wrapper.js"></script>

<script type="text/javascript" src="../incs/jquery.min.js"></script>

<script type="text/javascript" src="../incs/jquery.dataTables.nightly.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
$(document).ready(function() {
    var table = $('#example').DataTable({
        "columnDefs": [
            { "visible": false, "targets": 0 }
        ],
		"bPaginate": false,
        "paging":         false,
        "order": [[ 0, 'asc' ]],
        
		
		
		
		"drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="8">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
		
    } );
 
    // Order by the grouping
    $('#example tbody').on( 'click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if ( currentOrder[0] === 0 && currentOrder[1] === 'asc' ) {
            table.order( [ 0, 'desc' ] ).draw();
        }
        else {
            table.order( [ 0, 'asc' ] ).draw();
        }
		
		
    } );
} );
</script>

<script>
  $(function() {
    $( "#fromdate" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#todate" ).datepicker({ dateFormat: 'yy-mm-dd' });
  });
  </script>



</head>
<body style="margin:0px; padding:0px;">
<img src="../incs/blur.jpg" class="bg" />

<div class="tablescroll dataScreenOptimised" id="tablescroll" style="display:none;">
<table class="display" cellpadding="5" celspacing="0" width="100%" style="width:100%;">
<tr style='background-color:#666; color:#eee;'><td>Time</td><td>Name</td><td>Printer</td><td>Ink Name</td><td>Cost</td><td>Room</td><td>Detail</td><td>Note</td></tr>
</table>
</div>


<?PHP

include "../incs/menu.inc";


if (isset($_POST['I5'])) {
echo "old method, please use new add function.";
}

?>
<div class='HeaderBanner'>Audit <img src="../icns/question.png" /><div id="SubHeader" class='SubHeaderBanner'>Loading, please wait...</div></div>

<div class="main" onmouseover="Hide('ReportsMenu')" >
<!--
Server message would go here!
-->
<div>
<?PHP
if (isset($_GET['fromdate'])){
$fromdate = $_GET['fromdate'];
}
else {
$fromdate = date('Y') . '-' . date('m') . '-01';
}
if (isset($_GET['todate'])){
$todate = $_GET['todate'];
}
else {
$todate = date('Y') . '-' . date('m') . '-' . date('d');
}
?>
<div class='function'>
<input onchange="updatequery()" class="function" type="text" id="fromdate" value="<?PHP echo $fromdate;?>">
<input onchange="updatequery()" class="function" type="text" id="todate" value="<?PHP echo $todate;?>">
<a class="function refresh" href="javascript:location.reload();"><img src="../icns/refresh.png"/> Refresh!</a>
<a class="function wrapper" href="javascript:openwrapper('about:blank', '210', '210')"><img src="../icns/filter.png"/> Filter</a>
</div>
<table id="example" class="display" cellpadding="5" celspacing="0" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td width="90px">Date Y-M-D</td><td>Time</td><td>Name</td><td>Printer</td><td>Ink Name</td><td>Cost</td><td>Room</td><td>Detail</td><td>Note</td></tr>
</thead>
<tbody>
<?PHP

//Applying user defined filters to query
//All fields start as unfiltered
$stockremoved = "This item is not filtered";
$stockadded = "This item is not filtered";
$stockcheck = "This item is not filtered";
$productadded = "This item is not filtered";

IF (isset($_GET['filter'])){
//Stock removed tick box value (wildcard)
if (isset($_GET['stockremoved'])) {
//checked, do nothing.
}
else {
$stockremoved = '%removed%';
}

//Stock added tick box value (wildcard)
if (isset($_GET['stockadded'])) {
//checked, do nothing.
}
else {
$stockadded = '%added%';
}

//Stock check tick box value
if (isset($_GET['stockcheck'])) {
//checked, do nothing.
}
else {
$stockcheck = 'Stock Check Completed';
}

//Product added tick box value
if (isset($_GET['productadded'])) {
//checked, do nothing.
}
else {
$productadded = '%Product Added%';
}
}

//Audit Query
$result = mysqli_query($con, "SELECT * 
FROM  `AuditTrail` INNER JOIN users ON audittrail.UserID=users.UserID
WHERE (`Date` BETWEEN '$fromdate' AND '$todate') 
AND (Detail NOT LIKE '$stockremoved') 
AND (Detail NOT LIKE '$stockadded') 
AND (Detail NOT LIKE '$stockcheck') 
AND (Detail NOT LIKE '$productadded')");

$Entries = 0;
$Removed = 0;
$Added = 0;

while($row = mysqli_fetch_array($result))
  {
echo "<tr class='tinytext'  id='" . $row['AID'] . "' onclick=" . "'" . "highlightRow(" . $row['AID'] . ")" . "'" . " ><td>" . $row['Date'] . "</td><td>" . $row['Time'] . "</td><td>" . $row['Name'] . "</td><td>" . $row['Printer'] . "</td><td>" . $row['InkName'] . "</td><td>&pound;" . $row['Cost'] . "</td><td>" . $row['Department'] . "</td><td>" . $row['Detail'] . "</td><td>" . $row['Note'] . "</td></tr>";

$Entries ++;
if (substr($row['Detail'], -7, 5) == 'stock'){
$Added = $Added + substr($row['Detail'], 0, strpos($row['Detail'], ' '));
}
if (substr($row['Detail'], -7, 5) == 'ining'){
$Removed = $Removed + substr($row['Detail'], 0, strpos($row['Detail'], ' '));
}


  }
?>
</tbody>
<tfoot>
<tr><td colspan="5">&nbsp;</td></tr>
</tfoot>
</table>


<?php 

if ($Entries != 1) {
$EntriesLang = "entries";
}
else {
$EntriesLang = "entry";
}

if ($Removed != 1) {
$RemovedLang = "items";
}
else {
$RemovedLang = "item";
}

if ($Added != 1) {
$AddedLang = "items";
}
else {
$AddedLang = "item";
}

echo 
"<script>
window.onload = function(updatesubheader) {
document.getElementById('SubHeader').innerHTML = '$Entries $EntriesLang. $Removed $RemovedLang removed, $Added $AddedLang added.';
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

<!-- IN THIS INSTANCE, THE IFRAME IS NOT IN USE! AUDIT FILTER CONTROLS REPLACE IT! -->

<!-- Grey out background -->
<div id="grey" style="display:none;" onclick="closewrapper();">&nbsp;</div>

<!-- The white box that the window will reside in -->
<div id="iframewrapper" style="width: 750px; height: 230px; margin-left: -375px; margin-top: -95px; display: none;">

<!-- The 'X' button -->
<a href="javascript:void(0);" onclick="closewrapper();">
<img id="iframeX" src="../icns/X.png" style="position:relative; top:-5px; left:735px; border:0 none;">
</a>

<!-- Actual iFrame container -->
<div style="clear:both; padding:20px; padding-left:10px; margin-top:-50px;">
<iframe id="Iframe" style="margin:10px; height:220px; width:100%;display:none;" border="0" frameborder="0"></iframe>

<center>
<h2>Audit Filter</h2>
</center>
<form action="" method="GET">
<input type="checkbox" name="productadded" checked /> New Product Added </br>
<input type="checkbox" name="stockcheck" checked /> Stock Checks </br>
<input type="checkbox" name="stockadded" checked /> Stock Added </br>
<input type="checkbox" name="stockremoved" checked /> Stock Removed </br></br>
<!-- These fields are optional based on whether the user has modified date range prior to changing filters -->
<?php if(isset($_GET['fromdate'])){ ?><input type="hidden" name="fromdate" value="<?php echo $_GET['fromdate'];?>" /><?php } ?>
<?php if(isset($_GET['todate'])){ ?><input type="hidden" name="todate" value="<?php echo $_GET['todate'];?>" /><?php } ?>
<center><input type="submit" name="filter" value="Submit!" />
</form>

</div>

</div>
 
<!--
###########################################################################
########################## Iframe Section  End ############################
###########################################################################
-->
     
</body>
</HTML>