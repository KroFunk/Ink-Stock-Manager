<?PHP
session_start();
require "../../config/config.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Stock Manager | Ink Usage Report | &copy; Robin Wright 2014</title>
<script type="text/javascript" src="../../incs/robins.iframe.wrapper.js"></script>
<script type="text/javascript" src="../../incs/jquery.min.js"></script>
<script type="text/javascript" src="../../incs/jquery.dataTables.nightly.js"></script>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<link href='../../demo_table.css' rel='stylesheet' type='text/css'>
<style type="text/css">


	.function {
		float:left;
		width:400px;
		text-align:left;
	}
	.function img {
		vertical-align:middle;
	}
	.dataTables_info {
	text-align:left;
}
	.cell {
	border:0px none;
border-top:1px solid black;
padding:3px;
}
.group {
background:#ccc;
border-bottom:3px solid black;
margin-top:10px;
padding:5px;
font-weight:bold;
}
div.page
      {
        page-break-after: always;
        page-break-inside: avoid;
      }
@media print {
.dataTables_filter {
	display:none;
}


thead {
	display: table-header-group;
	}
.function {
	display:none;
}
}
</style>

<script>
$(document).ready(function() {
    var table = $('#example').DataTable({
        "columnDefs": [
            { "visible": false, "targets": 0 }
        ],
		"bPaginate": false,
        "paging":         false,
        "order": [[ 0, 'asc' ]],
		
		
		"drawCallback": function ( settings, row, data, start, end, display ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
			
			// Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/\u00A3/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                } );
 
            // Total over this page
            pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 3 ).footer() ).html(
                ' &pound;'+pageTotal.toFixed(2) +' (&pound;'+ total.toFixed(2) +' total)'
            );
			
			
			
			
 
            api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr ><td colspan="3"><div class="group">'+group+'</div></td></tr>'
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

</head>
<body><center>
<div style="font-family:Roboto, sans-serif; width:100%; max-width:800px;">
<div style="font-size:28px;margin-left:5px;font-weight:bold;font-family:sans-serif; text-align:left;">Ink Usage Report: <?php echo $_POST['fromdate'] . " / " . $_POST['todate']; ?></div>
<hr style="border:0; border-top:3px solid #000;">
<div class="function"><a href="javascript:window.print()"><img src="../../icns/printer.png" />Print</a> <a href="javascript:ShowHide('charts');" ><img src="../../icns/pie.png" /> Show/Hide Pie Charts</a></div>

<div class="page" id="charts">
<iframe src="/ink/reports/ink_usage/chart.php?v=Cost" width="100%" height="455px" frameborder="0" scrolling="no"></iframe>
<iframe src="/ink/reports/ink_usage/chart.php?v=Usage" width="100%" height="455px" frameborder="0" scrolling="no"></iframe>
</div>

<?PHP

$fromdate = $_POST['fromdate'];
$todate = $_POST['todate'];

$result = mysqli_query($con, "SELECT * 
FROM  `AuditTrail` INNER JOIN users ON audittrail.UserID=users.UserID
WHERE (`Date` BETWEEN '$fromdate' AND '$todate') AND (`Detail` LIKE '%removed%') ORDER BY `Printer`, `InkName` DESC") or die ('Unable to execute query. '. mysqli_error($con));


echo "<table cellpadding='0' cellspacing='0' style='width:100%; max-width:800px;' id='example'><thead><td>Printer</td><td>Ink Name</td><td style='text-align:center;'>Stock</td><td style='text-align:left;'>Value</td></thead>";
echo "<tfoot><td align='right' colspan='3'>Total Cost: </td><td align='left'>Loading...</td></tfoot><TBODY>";

$first = mysqli_fetch_array($result);
$lastink = $first['InkName'];
$lastprinter = $first['Printer'];
$buildused = 0;
$buildcost = 0;
unset($_SESSION['usage']);
unset($_SESSION['cost']);
$_SESSION['usage'] = array();
$_SESSION['cost'] = array();


while($row = mysqli_fetch_array($result))
  {
   
   if ($row['InkName'] != $lastink) {
	echo "<tr><td class='cell'>" . $lastprinter . "</td><td class='cell'>" . $lastink . "</td><td class='cell'><center>" . $buildused . "</center></td><td class='cell'>&pound;" . number_format(($buildcost), 2, '.', '') .  "</td></tr>";
	$_SESSION['usage'][] = array($lastprinter . " " . $lastink, $buildused);
	$_SESSION['cost'][] = array($lastprinter . " " . $lastink, $buildcost);
	
	$buildused = 0;
    $buildcost = 0;
}

$used = explode(" ", $row['Detail']);
 // echo "<tr><td>" . $row['Printer'] . "</td><td>" . $row['InkName'] . "</td><td>" . $used[0] . "</td><td>" . $row['Cost'] . "</td></tr>";
$buildused = $buildused + $used[0];
$buildcost = $buildcost + $row['Cost'];
  

  
   $lastink = $row['InkName'];
   $lastprinter = $row['Printer'];
  }
echo "<tr><td class='cell'>" . $lastprinter . "</td><td class='cell'>" . $lastink . "</td><td class='cell'><center>" . $buildused . "</center></td><td class='cell'>" . $buildcost . "</td></tr>";
    $_SESSION['usage'][] = array($lastprinter . " " . $lastink, $buildused);
	$_SESSION['cost'][] = array($lastprinter . " " . $lastink, $buildcost);
echo "</TBODY></table>";
?>
<div style="font-size:10px; text-align:left;clear:both;">Printer Usage Report, Generated <?php echo date('l jS \of F Y h:i:s A'); ?></div>
<div>
</center>
</body>
</html>















































