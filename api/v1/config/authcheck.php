<?php 
//########################################################################################
//###################### Nothing should be changed below this point ######################
//########################################################################################

require 'config.php';
header('Content-Type: application/json');
$Response = array();

//Checking Authentication. Same file as the SQL connection details to avoid spoofing. 
//Run check if user is not currently in the process of logging in
if(isset($_SESSION['CUID'])){
$CUID = $_SESSION['CUID'];
$authquery = mysqli_query($con, "SELECT * 
FROM  `users` 
WHERE `UserID` = '$CUID'
ORDER BY  `UserID` DESC 
LIMIT 0 , 99") or die ('Unable to execute query. '. mysqli_error($con));
$authresult = mysqli_fetch_array($authquery);
if($CUID==$authresult['UserID']){
$Response['response']['authcheck'] = array("status" => "success");
if($authresult['Admin']=='1') {
$_SESSION['IsAdmin']='1';
}
else {
$_SESSION['IsAdmin']='0';
}
}
else{
//send 403 error to browser and destroy session data. Server variable exists but user doesnt match the database. 
session_destroy();
$Response['response']['authcheck'] = array("status" => "fail" . $CUID);
echo json_encode($Response, JSON_PRETTY_PRINT);
exit;
}
}
else{
//send 403 error to browser and destroy session data
session_destroy();
$Response['response']['authcheck'] = array("status" => "fail" . $CUID);
echo json_encode($Response, JSON_PRETTY_PRINT);
exit;
}




?>