<?php 
//SQL connection details
$SQLServer="localhost";
$SQLUser="root";
$SQLPass="root";
$SQLDB="InkStock";

//Install information
$Directory="http://localhost/ink/";

//########################################################################################
//###################### Nothing should be changed below this point ######################
//########################################################################################
session_start();
//header('Content-Type: application/json');
$Response = array();
$Response['api name'] = "Robins Ink Stock Manager Web API";
$Response['api version'] = "1";

//Attempting to connect to db
$con=mysqli_connect($SQLServer,$SQLUser,$SQLPass,$SQLDB);
//check if the connection was sucessful (Fingers Crossed)
if (mysqli_connect_errno())
{
echo "Connection to the database fell over: " . mysqli_connect_error();
}



?>