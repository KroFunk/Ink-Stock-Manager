<?PHP

require "../../config/config.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Stock Manager | EOD Report | &copy; Robin Wright 2014</title>
<script type="text/javascript" src="../../incs/robins.iframe.wrapper.js"></script>
<script type="text/javascript" src="../../incs/jquery.min.js"></script>
<script type="text/javascript" src="../../incs/jquery.dataTables.nightly.js"></script>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<link href='../../demo_table.css' rel='stylesheet' type='text/css'>
<style type="text/css">
.dataTables_info {
	display:none;
}
.group {
background:#ccc;
border-bottom:3px solid black;
margin-top:10px;
padding:5px;
font-weight:bold;
}
.cell {
	border:0px none;
border-top:1px solid black;
padding:3px;
}
thead {
	display: table-header-group;
	}
	.function {
		float:left;
		width:200px;
		text-align:left;
	}
	.function img {
		vertical-align:middle;
	}
@media print {
.dataTables_filter {
	display:none;
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
<div style="font-size:28px;margin-left:5px;font-weight:bold;font-family:sans-serif; text-align:left;">EOD Report: <?php echo $_POST['fromdate']; ?></div>
<hr style="border:0; border-top:3px solid #000;">
<div class="function"><a href="javascript:window.print()"><img src="../../icns/printer.png" />Print</a></div>
<?PHP

$fromdate = $_POST['fromdate'] . " 23:59:59";

$result = mysqli_query($con, "Select * from eod INNER JOIN printers on eod.PID=printers.PID WHERE TimeStamp = '$fromdate'") or die ('Unable to execute query. '. mysqli_error($con));;
echo "<table cellpadding='0' cellspacing='0' style='width:100%; max-width:800px;' id='example'><thead><td>Printer</td><td>Ink Name</td><td style='text-align:center;'>Stock</td><td style='text-align:left;'>Value</td></thead>";
echo "<tfoot><td></td><td align='right'>Total Value: </td><td align='left' colspan='2'>Loading...</td></tfoot><TBODY>";
while($row = mysqli_fetch_array($result))
  {
 echo "<tr><td class='cell'>" . $row['PrinterMake'] . " " . $row['PrinterModel'] . "</td><td class='cell'>" . $row['InkName'] . "</td><td class='cell' style='text-align:center; width:100px'>" . $row['Stock'] . "</td><td class='cell' style='text-align:left; width:100px'>&pound;" . number_format(($row['Price']*$row['Stock']), 2, '.', '') . "</td></tr>";
  }
echo "</TBODY></table>";
?>
<div style="font-size:10px; text-align:left;">EOD Report, Generated <?php echo date('l jS \of F Y h:i:s A'); ?></div>
<div>
</center>
</body>
</html>