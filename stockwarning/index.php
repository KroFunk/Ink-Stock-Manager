<?PHP
session_start();
$SQLServer="localhost";
$SQLUser="root";
$SQLPass="root";
$SQLDB="InkStock";

//Attempting to connect to db
$con=mysqli_connect($SQLServer,$SQLUser,$SQLPass,$SQLDB);
//check if the connection was sucessful (Fingers Crossed)
if (mysqli_connect_errno())
{
echo "Connection to the database fell over: " . mysqli_connect_error();
}

$thisrow = 0;
$rowcss="";
echo "<div style='max-width:700px; margin:10px; border:1px solid #666; padding:0px; margin:0 auto; font-family:sans-serif;'>";
echo "<div style='background:#1d77f3; padding:10px;'><span style='font-size:32px; color:#fff;'>Ink Stock manager</span></div>";

echo "<div style='padding:10px;'>
Please order the following:
<table width='100%' cellpadding='5px'>
<thead style='background:#666;color:#fff;'>
<td align='left'>Product Code</td>
<td align='left'>Description</td>
<td align='left'>QTY</td>
</thead>";
$result = mysqli_query($con, "SELECT * FROM `stock` INNER JOIN `printers` ON `stock`.`PID` = `printers`.`PID`");
while($row = mysqli_fetch_array($result))
  {
  if($row['Stock'] <= $row['StockWarning'])
  		{
  		if ($thisrow % 2 == 0) {
  		$rowcss = "style='background:#eee;'";
  		}
  		else {
  		$rowcss = "style='background:#fff;'";
  		}
  		$thisrow = $thisrow + 1;
  		
  		$QTY = $row['StockDefault'] - $row['Stock'];
  		
		echo "<tr " . $rowcss . "><td align='left'>" . $row['ProductCode'] . "</td><td align='left'>" . $row['Description'] . "</td><td align='left'>"  . $QTY . "</td></tr>";
		}
  }
echo "</table>";
echo "<span style='font-size:10px;'>This is an automatically generated email sent to all administrators of Robin's Ink Stock Manager.</span>";
echo "</div></div>";
mysqli_close($con);
?>