<?PHP

require "../config/config.php";
?>

<HTML>
<head>
<title>Stock Manager | Stock Check | &copy; Robin Wright 2014</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<link href='../admin.css' rel='stylesheet' type='text/css'>
<link href='../demo_table.css' rel='stylesheet' type='text/css'>
</head>
<body>
<center>
<h2>Stock Check</h2>
<div style="border-radius:5px; background:#fff; width:710px; margin:10px; box-shadow:0px 0px 5px #000; padding:10px;">
<?php
foreach ($_SESSION['IIDS'] as $currIID) {
$Stock = $_POST[$currIID];
mysqli_query($con,"UPDATE  `InkStock`.`Stock` SET  `Stock` =  '$Stock'  WHERE  `Stock`.`IID` = $currIID;");
}
echo "Stock Check complete, you may now close this window.<br/><br/>";
$thisrow = 0;
$rowcss="";
echo "<div style='width:700px; margin:10px; border:1px solid #666; padding:0px; margin:0 auto; font-family:sans-serif;text-align:left;'>";
echo "<div style='background:#1d77f3; padding:10px;'><img src='http://portal.rydeschool.org.uk/chalkcreation.png' style='width:25px;'><span style='font-size:32px; color:#fff; vertical-align:middle;'> Robin's Ink Stock manager</span></div>";
echo "<div style='padding:10px;'>
The following report shows discrepancies after stock check:
<table width='100%' cellpadding='5px'>
<thead style='background:#666;color:#fff;'>
<td align='left'>Ink Name</td>
<td align='center'>Old Stock Amount</td>
<td align='center'>New Stock Amount</td>
</thead>";

foreach ($_SESSION['IIDS'] as $currIID){
$CSIID = "CS" . $currIID;
$CIN = "CIN" . $currIID;
$CUID = $_SESSION['CUID'];
$today = date('Y') . '-' . date('m') . '-' . date('d');
$theTime = date('H') . ":" . date('i');


mysqli_query($con,"INSERT INTO `inkstock`.`StockChecks` (`SCID`, `Date`, `Time`, `UserID`, `IID`, `OldStock`, `NewStock`) VALUES (NULL, '$today', '$theTime', '$CUID', '$currIID', '$_POST[$CSIID]', '$_POST[$currIID]');") or die ('Unable to execute query. '. mysqli_error($con));


  if($_POST[$CSIID] != $_POST[$currIID])
  		{
  		if ($thisrow % 2 == 0) {
  		$rowcss = "style='background:#eee;'";
  		}
  		else {
  		$rowcss = "style='background:#fff;'";
  		}
  		$thisrow = $thisrow + 1;
		echo "<tr " . $rowcss . "><td align='left'>" . $_POST[$CIN] . "</td><td align='center'>" . $_POST[$CSIID] . "</td><td align='center'>"  . $_POST[$currIID] . "</td></tr>";
		}
  }
echo "</table>";
echo "<span style='font-size:10px;'>This is an automatically generated email sent to all administrators of Robin's Ink Stock Manager.</span>";
echo "</div></div>";


$printer = "-";
$inkname = "-";
$cost = "0";
$department = "-";
$note = "<a href=" . '"stockcheckdisplay.php?date=' . $today . "&time=" . $theTime . '"' . ">Show Report</a>";
$UserID = $_SESSION['CUID'];
$detail = "Stock Check Completed";

mysqli_query($con,"INSERT INTO  `InkStock`.`AuditTrail` (
`AID` ,
`Date` ,
`Time` ,
`UserID` ,
`Printer` ,
`InkName` ,
`Cost` ,
`Department` ,
`Detail` ,
`Note`
)
VALUES (
NULL, '$today',  '$theTime', '$UserID', '$printer',  '$inkname',  '$cost',  '$department',  '$detail',  '$note'
);") or die ('Unable to execute query. '. mysqli_error($con));


?>
</div>
</center>
</body>
</HTML>
<?PHP
mysqli_close($con);
?>