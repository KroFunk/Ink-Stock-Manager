<?PHP

require "../config/config.php";
?>

<HTML>
<head>
<title>Stock Manager | Admin | &copy; Robin Wright 2014</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<link href='../adminwhite.css' rel='stylesheet' type='text/css'>
<link href='demo_table.css' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="incs/jquery.min.js"></script>

<script type="text/javascript" src="incs/jquery.dataTables.nightly.js"></script>


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

<h2>10 Most recent actions for <?php echo $_GET['index']; ?></h2>
<table id="audit" class="display" cellpadding="5" celspacing="0" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td>Date Y-M-D</td><td>Time</td><td>Ink Name</td><td>Cost</td><td>Department</td><td>Detail</td><td>Note</td></tr>
</thead>
<tbody>
<?PHP
$inks = mysqli_query($con, "SELECT * 
FROM  `AuditTrail` 
WHERE  `InkName` =  '$InkName'
ORDER BY  `AID` DESC 
LIMIT 0 , 10") or die ('Unable to execute query. '. mysqli_error($con));

while($row = mysqli_fetch_array($inks))
  {

  echo "<tr><td>" . $row['Date'] . "</td><td>" . $row['Time'] . "</td><td>" . $row['InkName'] . "</td><td>&pound;" . $row['Cost'] . "</td><td>" . $row['Department'] . "</td><td>" . $row['Detail'] . "</td><td>" . $row['Note'] . "</td></tr>";

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
 
     
</body>
</HTML>