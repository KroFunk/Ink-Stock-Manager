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

mysqli_query($con, "INSERT INTO eod (`PID`,`InkName`,`Price`,`Stock`) SELECT `PID`,`InkName`,`Price`,`Stock` FROM stock;");

echo "EOD Table Updated";

mysqli_close($con);
?>