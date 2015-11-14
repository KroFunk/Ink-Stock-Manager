<?PHP

require "../config/config.php";
?>

<HTML>
<head>
<title>Stock Manager | Admin | &copy; Robin Wright 2014</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<link href='../adminwhite.css' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="../incs/jquery.min.js"></script>

</head>
<body style="margin:0px; padding:0px;">



<div class="notmain">
<!--
Server message would go here!
-->
<div>



<?PHP
$InkName = $_GET['index'];
?>

<h1>10 Most recent actions for <?php echo $_GET['index']; ?></h1>
<table id="auditTitle" class="display" cellpadding="5" cellspacing="0" style="width:100%;table-layout:fixed;">

<tr style='background-color:#666; color:#eee;'><td style='width:90px;'>Date Y-M-D</td><td style='width:50px;'>Time</td><td style='width:150px;'>Ink Name</td><td style='width:60px;'>Cost</td><td style='width:150px;'>Department</td><td style='width:220px;'>Detail</td><td>Note</td></tr>

</table>

<div style="width:100%;height:410px;overflow-y:scroll;">
<table id="auditTitle" class="display" cellpadding="5" cellspacing="0" style="width:100%;table-layout:fixed;">

<tbody>
<?PHP
$inks = mysqli_query($con, "SELECT * 
FROM  `AuditTrail` 
WHERE  `InkName` =  '$InkName'
ORDER BY  `AID` DESC 
LIMIT 0 , 10") or die ('Unable to execute query. '. mysqli_error($con));

while($row = mysqli_fetch_array($inks))
  {

  echo "<tr><td style='width:90px;'>" . $row['Date'] . "</td><td style='width:50px;'>" . $row['Time'] . "</td><td style='width:150px;'>" . $row['InkName'] . "</td><td style='width:60px;'>" . $Currency . $row['Cost'] . "</td><td style='width:150px;'>" . $row['Department'] . "</td><td style='width:220px;'>" . $row['Detail'] . "</td><td>" . $row['Note'] . "</td></tr>";

  }
?>
</tbody>
</table>
</div>





<?PHP
mysqli_close($con);
?>

<p style="margin:0px;padding:0px;clear:both;text-align:center;"></p>

</div>
</div>
 
     
</body>
</HTML>