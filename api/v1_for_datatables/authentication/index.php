<?PHP
header('Content-Type: application/json');
require "../config/config.php";
$Response['operation'] = "authentication";
$Response['response'] = array();
if(isset($_POST['action'])){
if($_POST['action'] == "logout"){
Session_destroy();
$Response['response'][] = array( "request" => "logout", "status" => "success");
}
elseif($_POST['action'] == "login"){
if(isset($_POST['email'])&&isset($_POST['password'])){
$email = strtolower($_POST['email']);
$authquery = mysqli_query($con, "SELECT * 
FROM  `users` 
WHERE `Email` = '$email'
ORDER BY  `UserID` DESC 
LIMIT 0 , 99") or die ('Unable to execute query. '. mysqli_error($con));
$authresult = mysqli_fetch_array($authquery);
if (password_verify($_POST['password'], $authresult['Password'])){
$_SESSION['CUID'] = $authresult['UserID'];
$Response['response'] = array();
$Response['response'][] = array( "request" => "login", "status" => "success");
if ($authresult['Admin'] = True){
$_SESSION['IA'] = True;
}
else {
$_SESSION['IA'] = False;
}
}
else {
$Response['response'][] = array( "request" => "login", "status" => "fail");
}
mysqli_close($con);
}
}
}
else {
$Response['response'][] = array( "request" => "none", "status" => "fail");
}
echo json_encode($Response, JSON_PRETTY_PRINT);
