<?PHP

require "../config/config.php";

$IIDS = array();
$ProductCount = 0;
?>

<HTML>
<head>
<title>Stock Manager | Stock Check | &copy; Robin Wright 2014</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->

<link href='../admin.css.php' rel='stylesheet' type='text/css'>
<link href='../demo_table.css' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="../incs/jquery.min.js"></script>
<script type="text/javascript" src="../incs/jquery.dataTables.nightly.js"></script>

<script>
$(document).ready(function() {
    $('#example').dataTable( {
	"bPaginate": false,
	"bFilter": false,
	"bInfo": false,
	"bAutoWidth": false,
		
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

</head>
<body style="margin:0px; padding:0px;text-align:center;">
<img src="../incs/blur.jpg" class="bg" />
<center><br/>
<h2>Stock Check</h2>
<div style=" background:#fff; width:100%; max-width:400px; margin:10px;">
<form method="post" action="commit.php">
<table id="example" class="display" style="width:100%;font-size:20px;">
<thead>
<td style="width:60px;"><b>Type</b></td><td style="text-align:left;"><b>Ink Name</b></td><td style="width:80px; text-align:left;"><b>Stock</b></td>
</thead>
<tfoot style="display:none;">
<td></td><td></td><td></td>
</tfoot>
<?php
$Inks = mysqli_query($con, "SELECT * FROM `Stock` INNER JOIN printers ON `stock`.`PID`=`printers`.`PID`;");
while($Ink = mysqli_fetch_array($Inks))
  {
  ?>
  
  <tr>
  <td><?php echo $Ink['Type'];?></td>
  <td><?php echo $Ink['PrinterMake'] . " " . $Ink['InkName'];?></td>
  <td>
  <input name="<?php echo $Ink['IID']; ?>" type="number" style="width:50px;" value="<?php echo $Ink['Stock']; ?>" />
  <input name="CIN<?php echo $Ink['IID']; ?>" type="hidden" value="<?php echo $Ink['PrinterMake'] . " " . $Ink['InkName'];?>" />
  <input name="CS<?php echo $Ink['IID']; ?>" type="hidden" value="<?php echo $Ink['Stock']; ?>" />
  </td>
  </tr>
  
  <?php
    array_push($IIDS, $Ink['IID']);
	$ProductCount++;
  }
?>
</table>
<br/>
<input type="submit" value="Submit" style="width:250px; font-size:22px; background-color:#297ACC; border-color:#103152; color:#fff; padding:5px;margin-bottom:25px;"/>
</form>
</div>
</center>


<?php
$_SESSION['IIDS'] = $IIDS;
$_SESSION['ProductCount'] = $ProductCount;
?>
</body>
</HTML>
<?PHP
mysqli_close($con);
?>