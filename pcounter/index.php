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
<script type="text/javascript" src="../incs/jquery.dataTables.nightly.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
$(document).ready(function() {
    $('#departmentsummarytable').dataTable( {
    "columnDefs": [
    { "orderData": [ 0, 1 ],    "targets": 0 }
    ],
    "bPaginate": false,
	"bAutoWidth": false,
} );
    $('#printersummarytable').dataTable( {
    "columnDefs": [
    { "orderData": [ 0, 1 ],    "targets": 0 }
    ],
    "bPaginate": false,
	"bAutoWidth": false,
} );
} );
</script>

<script>
  $(function() {
    $( "#fromdate" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#todate" ).datepicker({ dateFormat: 'yy-mm-dd' });
  });
  function updatequery(){
window.location.assign('<?php echo $Location ?>/pcounter/?fromdate=' + document.getElementById("fromdate").value + '&todate=' + document.getElementById("todate").value);
}
  </script>
<style>
table, tr, td {
    border:1px solid black;
    border-collapse: collapse;
}
</style>

</head>
<body style="margin:0px; padding:0px;">
<img src="../incs/blur.jpg" class="bg" />
<div class="tablescroll dataScreenOptimised" id="tablescroll" style="display:none;">
<table class="display" cellpadding="5" celspacing="0" width="100%" style="width:100%;">
<tr style='background-color:#666; color:#eee;'><td style="width:250px;">Email Address</td><td>Name</td><td>Administrator</td><td>Mailings</td><td>Edit</td><td>Password</td><td>Delete</td></tr>
</table>
</div>



<?PHP
echo "<div id='menu'>";
include "../incs/menu.inc";
echo "</div>";


if (isset($_POST['I5'])) {
echo "old method, please use new add function.";
}

?>
<div class='HeaderBanner'>PCounter Logs <img src="../icns/question.png" /><div id="SubHeader" class='SubHeaderBanner'>Review PCounter Logs and Reports</div></div>
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
$fromdate = date('Y-m-01', strtotime('-1 month'));
}
if (isset($_GET['todate'])){
$todate = $_GET['todate'];
}
else {
$todate = date('Y-m-01');
}
?>
<div class='function'>
<input onchange="updatequery()" class="function" type="text" id="fromdate" value="<?PHP echo $fromdate;?>">
<input onchange="updatequery()" class="function" type="text" id="todate" value="<?PHP echo $todate;?>">
<a class="function wrapper" href="javascript:openwrapper('addnew.php',640,320)"><img src="../icns/new.png"/> Import Log Data</a>
<a class="function wrapper" href="javascript:openwrapper('delete.php',640,320)"><img src="../icns/delete.png"/> Delete Log Data</a>
<div class="function wrapper"><img src="../icns/eye.png"/> <b>Show/Hide:</b> </div>
    <a class="function wrapper" style="padding-top:4px;" href="javascript:ShowHide('printerbreakdown')">Printer Breakdown</a>
    <a class="function wrapper" style="padding-top:4px;" href="javascript:ShowHide('departmentsummary')">Department Totals</a>
    <a class="function wrapper" style="padding-top:4px;" href="javascript:ShowHide('printersummary')">Printer Totals</a>
<a class="function refresh" href="javascript:location.reload();"><img src="../icns/refresh.png"/> Refresh!</a>
</div>



<?PHP
echo "<h2 style='clear:both;padding-top:20px;'>Pcounter Log Overview ($fromdate to $todate)</h2>";
$result = mysqli_query($con, "SELECT `PrinterModel`, `Date`, `Department`, `Paper Size`, `CommandString`, `Pages`, `Cost` FROM `pcounter` WHERE (`Date` BETWEEN '" . date('Y-m-d',strtotime($fromdate)) . "' AND '" . date('Y-m-d',strtotime($todate)) . "') AND (`PrinterModel` NOT LIKE '%Administrator%') AND (`PrinterModel` NOT LIKE '') ORDER BY `PrinterModel`, `Department` ASC") or die ('Unable to execute query. '. mysqli_error($con));

echo "<b>(For Diagnostic Use) Query Executed:</b> SELECT `PrinterModel`, `Date`, `Department`, `Paper Size`, `CommandString`, `Pages`, `Cost` FROM `pcounter` WHERE (`Date` BETWEEN '" . date('Y-m-d',strtotime($fromdate)) . "' AND '" . date('Y-m-d',strtotime($todate)) . "') AND (`PrinterModel` NOT LIKE '%Administrator%') AND (`PrinterModel` NOT LIKE '') ORDER BY `PrinterModel`, `Department` ASC</br>";

$TotalColourJobs = 0;
$TotalColourPages = 0;
$TotalColourCost = 0;
$TotalJobs = 0;
$TotalPages = 0;
$TotalCost= 0;

$DepartmentColourJobs = 0;
$DepartmentColourPages = 0;
$DepartmentColourCost = 0;
$DepartmentJobs = 0;
$DepartmentPages = 0;
$DepartmentCost = 0;

$PrinterColourJobs = 0;
$PrinterColourPages = 0;
$PrinterColourCost = 0;
$PrinterJobs = 0;
$PrinterPages = 0;
$PrinterCost = 0;

$DepartmentArray = array();
$PrinterArray = array();

$CurrentPrinter = "";
$CurrentDepartment = "";
$LastPrinter = "";
$LastDepartment = "";

echo "<div id='printerbreakdown' style='float:left;display:block;'>";
echo "<h1>Printer Breakdown</h1>";
while($row = mysqli_fetch_array($result))
  {
      //Set Current Department and Printer for this record
      $CurrentDepartment = $row['Department'];
      $CurrentPrinter = $row['PrinterModel'];
      
      //Totals increase regardless of department or printer
      if (strpos($row['CommandString'], '/C/') !== false) { //If the /C/ flag is in the command string, append coliur totals
          $TotalColourJobs++;
          $TotalColourPages += $row['Pages'];
          $TotalColourCost += $row['Cost'];
      }
      $TotalJobs++;
      $TotalPages += $row['Pages'];
      $TotalCost += $row['Cost'];
      
      
      
      
      //if colour, append colour values
           if (strpos($row['CommandString'], '/C/') !== false) {
           $DepartmentColourJobs++;
           $DepartmentColourPages += $row['Pages'];
           $DepartmentColourCost += $row['Cost'];
           
           $PrinterColourJobs++;
           $PrinterColourPages += $row['Pages'];
           $PrinterColourCost += $row['Cost'];
           }
           
           $DepartmentJobs++;
           $DepartmentPages += $row['Pages'];
           $DepartmentCost += $row['Cost'];
          
           $PrinterJobs++;
           $PrinterPages += $row['Pages'];
           $PrinterCost += $row['Cost'];
      
      
      
      
      
      
      //Set the initial title and open the table if this is the first run
      if(empty($LastPrinter)){
          $LastDepartment = $row['Department'];
          $LastPrinter = $row['PrinterModel'];
          
          if(empty($row['Department'])){
              $DepartmentName = "Unassigned";
          }
          else {
              $DepartmentName = $row['Department'];
          }
          
          echo "<h2>" . $row['PrinterModel'] . "</h2>";
          echo "<table border='1' cellpadding='5' cellspacing='0' style='width:450px;'><thead style='background-color:#666; color:#eee;'><td style='width:250px;'>Department</td><td style='width:50px;'>Jobs</td><td style='width:50px;'>Mono Pages</td><td style='width:50px;'>Colour Pages</td></thead>";
      }
      
      
      //If current department is different to last printer, dump totals and reset variables. 
      If($CurrentDepartment != $LastDepartment) {
          
          if(empty($LastDepartment)){
              $DepartmentName = "Unassigned";
          }
          else {
              $DepartmentName = $LastDepartment;
          }
          
           echo "<tr><td>". $DepartmentName ."</td><td>" . $DepartmentJobs . "</td><td>" . ($DepartmentPages - $DepartmentColourPages) . "</td><td>" . $DepartmentColourPages . "</td></tr>";
           
           if(!isset($DepartmentArray["$DepartmentName"])){
               $DepartmentArray["$DepartmentName"] = array();
           }
           $DepartmentArray["$DepartmentName"]['Department'] = $DepartmentName;
           $DepartmentArray["$DepartmentName"]['Jobs'] = $DepartmentArray["$DepartmentName"]['Jobs'] + $DepartmentJobs;
           $DepartmentArray["$DepartmentName"]['ColourJobs'] = $DepartmentArray["$DepartmentName"]['ColourJobs'] + $DepartmentColourJobs;
           $DepartmentArray["$DepartmentName"]['Pages'] = $DepartmentArray["$DepartmentName"]['Pages'] + $DepartmentPages;
           $DepartmentArray["$DepartmentName"]['ColourPages'] = $DepartmentArray["$DepartmentName"]['ColourPages'] + $DepartmentColourPages;
           $DepartmentArray["$DepartmentName"]['Cost'] = $DepartmentArray["$DepartmentName"]['Cost'] + $DepartmentCost;
           $DepartmentArray["$DepartmentName"]['ColourCost'] = $DepartmentArray["$DepartmentName"]['ColourCost'] + $DepartmentColourCost;
           
           $DepartmentColourJobs = 0;
           $DepartmentColourPages = 0;
           $DepartmentColourCost = 0;
           $DepartmentJobs = 0;
           $DepartmentPages = 0;
           $DepartmentCost = 0;

           }
      
      //If current printer is different to last printer, dump totals and reset variables. 
      If($CurrentPrinter != $LastPrinter) {
          echo "</table>";
          
          
           $PrinterArray["$LastPrinter"] = array();
           $PrinterArray["$LastPrinter"]['Printer'] = "$LastPrinter";
           $PrinterArray["$LastPrinter"]['Jobs'] += $PrinterJobs;
           $PrinterArray["$LastPrinter"]['ColourJobs'] += $PrinterColourJobs;
           $PrinterArray["$LastPrinter"]['Pages'] += $PrinterPages;
           $PrinterArray["$LastPrinter"]['ColourPages'] += $PrinterColourPages;
           $PrinterArray["$LastPrinter"]['Cost'] += $PrinterCost;
           $PrinterArray["$LastPrinter"]['ColourCost'] += $PrinterColourCost;
           
           $PrinterColourJobs = 0;
		   $PrinterColourPages = 0;
		   $PrinterColourCost = 0;
		   $PrinterJobs = 0;
		   $PrinterPages = 0;
		   $PrinterCost = 0;
           
          
          
          echo "<h2>" . $row['PrinterModel'] . "</h2>";
          echo "<table border='1' cellpadding='5' cellspacing='0' style='width:450px;'><thead style='background-color:#666; color:#eee;' ><td style='width:250px;'>Department</td><td style='width:50px;'>Jobs</td><td style='width:50px;'>Mono Pages</td><td style='width:50px;'>Colour Pages</td></thead>";
      }
      
      
      
      
           
           
           
      
      
      
      
      
      
      $LastDepartment = $CurrentDepartment;
      $LastPrinter = $CurrentPrinter;
         
  }
if(empty($LastDepartment)){
              $DepartmentName = "Unassigned";
          }
          else {
              $DepartmentName = $LastDepartment;
          }
echo "<tr><td>". $DepartmentName ."</td><td>" . $DepartmentJobs . "</td><td>" . ($DepartmentPages - $DepartmentColourPages) . "</td><td>" . $DepartmentColourPages . "</td></tr>"; 
           if(!isset($DepartmentArray["$DepartmentName"])){
               $DepartmentArray["$DepartmentName"] = array();
           }
           
           $DepartmentArray["$DepartmentName"]['Department'] = $DepartmentName;
           $DepartmentArray["$DepartmentName"]['Jobs'] = $DepartmentArray["$DepartmentName"]['Jobs'] + $DepartmentJobs;
           $DepartmentArray["$DepartmentName"]['ColourJobs'] = $DepartmentArray["$DepartmentName"]['ColourJobs'] + $DepartmentColourJobs;
           $DepartmentArray["$DepartmentName"]['Pages'] = $DepartmentArray["$DepartmentName"]['Pages'] + $DepartmentPages;
           $DepartmentArray["$DepartmentName"]['ColourPages'] = $DepartmentArray["$DepartmentName"]['ColourPages'] + $DepartmentColourPages;
           $DepartmentArray["$DepartmentName"]['Cost'] = $DepartmentArray["$DepartmentName"]['Cost'] + $DepartmentCost;
           $DepartmentArray["$DepartmentName"]['ColourCost'] = $DepartmentArray["$DepartmentName"]['ColourCost'] + $DepartmentColourCost;
           
           $PrinterArray["$LastPrinter"] = array();
           $PrinterArray["$LastPrinter"]['Printer'] = "$LastPrinter";
           $PrinterArray["$LastPrinter"]['Jobs'] += $PrinterJobs;
           $PrinterArray["$LastPrinter"]['ColourJobs'] += $PrinterColourJobs;
           $PrinterArray["$LastPrinter"]['Pages'] += $PrinterPages;
           $PrinterArray["$LastPrinter"]['ColourPages'] += $PrinterColourPages;
           $PrinterArray["$LastPrinter"]['Cost'] += $PrinterCost;
           $PrinterArray["$LastPrinter"]['ColourCost'] += $PrinterColourCost;
echo "</table></div>";



echo '<div style="float:right;padding:10px;">';
echo "<h1>Totals</h1>";
echo "<h3>Colour Totals</h3>";
echo "Colour Jobs " . number_format($TotalColourJobs) . "<br/>";
echo "Colour Pages " . number_format($TotalColourPages) . "<br/>";
echo "Colour Cost " . number_format($TotalColourCost,2) . "<br/>";
echo "<h3>Mono Totals</h3>";
echo "Mono Jobs " . number_format(($TotalJobs - $TotalColourJobs)) . "<br/>";
echo "Mono Pages " . number_format(($TotalPages - $TotalColourPages)) . "<br/>";
echo "Mono Cost " . number_format(($TotalCost - $TotalColourCost),2) . "<br/>";
echo "<h3>Overall Totals</h3>";
echo "Jobs " . number_format($TotalJobs) . "<br/>";
echo "Pages " . number_format($TotalPages) . "<br/>";
echo "Cost " . number_format($TotalCost,2) . "<br/>";
echo '</div>';





//Department Summary
echo "<div id='departmentsummary' style='float:left;padding-left:10px;display:block;max-width:950px;'>";
echo "<h1>Department Totals</h1>
<table id='departmentsummarytable' border='0' cellpadding='5' cellspacing='0' style='width:950px;'>";
echo "<thead style='background-color:#666; color:#eee;' >
<td class='department' style='width:250px;'>Department</td>
<td class='colourjobs'>Colour Jobs</td>
<td class='colourpages'>Colour Pages</td>
<td class='colourcost'>Colour Cost</td>
<td class='monojobs'>Mono Jobs</td>
<td class='monopages'>Mono Pages</td>
<td class='monocost'>Mono Cost</td>
<td class='totaljobs'>Total Jobs</td>
<td class='totalpages'>Total Pages</td>
<td class='totalcost'>Total Cost</td>
</thead><tfoot><td colspan='10'>&nbsp;</td></tfoot><tbody class='list'>";
foreach ($DepartmentArray as $summary) {
        echo "<tr>
        <td class='department'>" . $summary['Department'] . "</td>
        <td class='colourjobs' style='text-align:right;'>" . $summary['ColourJobs'] . "</td>
        <td class='colourpages' style='text-align:right;'>" . $summary['ColourPages'] . "</td>
        <td class='colourcost' style='text-align:right;'>&pound;" . number_format($summary['ColourCost'], 2) . "</td>
        <td class='monojobs' style='text-align:right;'>" . ($summary['Jobs'] - $summary['ColourJobs']) . "</td>
        <td class='monopages' style='text-align:right;'>" . ($summary['Pages'] - $summary['ColourPages']) . "</td>
        <td class='monocost' style='text-align:right;'>&pound;" . number_format(($summary['Cost'] - $summary['ColourCost']), 2) . "</td>
        <td class='totaljobs' style='text-align:right;'>" . $summary['Jobs'] . "</td>
        <td class='totalpages' style='text-align:right;'>" . $summary['Pages'] . "</td>
        <td class='totalcost' style='text-align:right;'>&pound;" . number_format($summary['Cost'], 2) . "</td>
        </tr>";
}
echo "</tbody></table></div>";


echo "<div id='printersummary' style='float:left;padding-left:10px;display:block;max-width:950px;'>
<h1>Printer Totals</h1>
<table id='printersummarytable' border='0' cellpadding='5' cellspacing='0' style='width:950px;'>";
echo "<thead style='background-color:#666; color:#eee;' >
<td class='printer' style='width:250px;'>Printer</td>
<td class='colourjobs'>Colour Jobs</td>
<td class='colourpages'>Colour Pages</td>
<td class='colourcost'>Colour Cost</td>
<td class='monojobs'>Mono Jobs</td>
<td class='monopages'>Mono Pages</td>
<td class='monocost'>Mono Cost</td>
<td class='totaljobs'>Total Jobs</td>
<td class='totalpages'>Total Pages</td>
<td class='totalcost'>Total Cost</td>
</thead><tfoot><td colspan='10'>&nbsp;</td></tfoot><tbody class='list'>";
foreach ($PrinterArray as $summary) {
		echo "<tr>
        <td class='department'>" . $summary['Printer'] . "</td>
        <td class='colourjobs' style='text-align:right;'>" . $summary['ColourJobs'] . "</td>
        <td class='colourpages' style='text-align:right;'>" . $summary['ColourPages'] . "</td>
        <td class='colourcost' style='text-align:right;'>&pound;" . number_format($summary['ColourCost'], 2) . "</td>
        <td class='monojobs' style='text-align:right;'>" . ($summary['Jobs'] - $summary['ColourJobs']) . "</td>
        <td class='monopages' style='text-align:right;'>" . ($summary['Pages'] - $summary['ColourPages']) . "</td>
        <td class='monocost' style='text-align:right;'>&pound;" . number_format(($summary['Cost'] - $summary['ColourCost']), 2) . "</td>
        <td class='totaljobs' style='text-align:right;'>" . $summary['Jobs'] . "</td>
        <td class='totalpages' style='text-align:right;'>" . $summary['Pages'] . "</td>
        <td class='totalcost' style='text-align:right;'>&pound;" . number_format($summary['Cost'], 2) . "</td>
        </tr>";
}

echo "</tbody></table></div>";












?>
<p style='clear:both;'></p>
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
############################# Iframe Section ##############################
###########################################################################
-->


<script type="text/javascript" src="../incs/lightbox.wrapper.js"></script>
 
     
</body>
</HTML>