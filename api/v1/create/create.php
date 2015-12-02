<?PHP
require "../../../config/config.php";
require "../../../auth/authcheck.php";

$Response['operation'] = "create";
$Response['response'] = array();
if(isset($_POST['action'])){
if($_SESSION['IsAdmin'] == 1) {
$theDate = date('Y') . "-" . date('m') . "-" . date('d');
$theTime = date('H') . ":" . date('i');

//------------------\\
//-- Create Stock --\\
//------------------\\

// 

//$PID . $inkname . $price . $stock . $stockwarning . $stockdefault . $productcode . $description . $orderurl . $onorder . $UPC

if($_POST['action'] == "createstock"){
	if($_POST['PID'] != "" && $_POST['inkname'] != "" && $_POST['price'] != "" && $_POST['stock'] != "" && $_POST['stockwarning'] != "" && $_POST['stockdefault'] != "" && $_POST['productcode'] != "" && $_POST['description'] != "" && $_POST['orderurl'] != "" && $_POST['onorder'] != "" && $_POST['UPC'] != ""){
		$PID = $_POST['PID'];
		$inkname = $_POST['inkname'];
		$price = $_POST['price'];
		$stock = $_POST['stock'];
		$stockwarning = $_POST['stockwarning'];
		$stockdefault = $_POST['stockdefault'];
		$productcode = $_POST['productcode'];
		$description = $_POST['description'];
		$orderurl = $_POST['orderurl'];
		$onorder = $_POST['onorder'];
		$UPC = $_POST['UPC'];
		mysqli_query($con, "INSERT INTO `inkstock`.`stock` (`IID`, `PID`, `InkName`, `Price`, `Stock`, `StockWarning`, `StockDefault`, `ProductCode`, `Description`, `OrderURL`, `OnOrder`, `UPC`)
		VALUES (NULL, '$PID', '$inkname', '$price', '$stock', '$stockwarning', '$stockdefault', '$productcode', '$description', '$orderurl', '$onorder', '$UPC' );") or die ('Unable to execute query. '. mysqli_error($con));
		
		$querystring = "`PID` = '$PID', `InkName` = '$inkname', `Price` = '$price', `Stock` = '$stock', `StockWarning` = '$stockwarning', `StockDefault` = '$stockdefault', `ProductCode` = '$productcode', `Description` = '$description', `OrderURL` = '$orderurl', `OnOrder` = '$onorder', `UPC` = '$UPC'";
		
		$encodedquery = htmlentities($querystring, ENT_QUOTES);
		mysqli_query($con,"INSERT INTO  `$SQLDB`.`AuditTrail` (
`AID` ,
`Date` ,
`Time` ,
`UserID` ,
`Printer` ,
`InkName` ,
`Cost` ,
`Department` ,
`Detail` ,
`Note`
)
VALUES (
NULL,  '$theDate',  '$theTime', '$CUID', '$printer',  '$inkname',  '-',  '-',  'Stock record was created',  '$encodedquery'
);") or die ('Unable to execute query. '. mysqli_error($con));
		$Response['response'][] = array( "request" => "createstock", "status" => "success");
	}
	else {
		$Response['response'][] = array( "request" => "createstock", "status" => "fail");
	}        
}

//--------------------\\
//-- Create Printer --\\
//--------------------\\

else if($_POST['action'] == "createprinter"){
	if($_POST['printermake'] != "" && $_POST['printermodel'] != "" && $_POST['supportlink'] != "" && $_POST['colour'] != "" && $_POST['media'] != "" && $_POST['type'] != "" ){
		$printermake = $_POST['printermake'];
		$printermodel = $_POST['printermodel'];
		$supportlink = $_POST['supportlink'];
		$colour = $_POST['colour'];
		$media = $_POST['media'];
		$type = $_POST['type'];
		$PID = $_POST['PID'];
		mysqli_query($con, "INSERT INTO `inkstock`.`printers` (`PID`, `PrinterMake`, `PrinterModel`, `SupportLink`, `Colour`, `Media`, `Type` ) 
		VALUES (NULL, '$printermake', '$printermodel', '$supportlink', '$colour', '$media', '$type' );") or die ('Unable to execute query. '. mysqli_error($con));
		$Response['response'][] = array( "request" => "createprinter", "status" => "success");
	}
	else {
		$Response['response'][] = array( "request" => "createprinter", "status" => "fail");
	}
}

//-----------------\\
//-- Create User --\\
//-----------------\\

else if($_POST['action'] == "createuser"){
	if($_POST['name'] != "" && $_POST['email'] && $_POST['admin'] != "" && $_POST['mail'] != "" && $_POST['password'] != "") {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$admin = $_POST['admin'];
		$mail = $_POST['mail'];
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		mysqli_query($con, "INSERT INTO `inkstock`.`users` (`UserID`, `Name`, `Email`, `Admin`, `Mail`, `Password` ) 
		VALUES (NULL, '$name', '$email', '$admin', '$mail', '$password' );") or die ('Unable to execute query. '. mysqli_error($con));
		$Response['response'][] = array( "request" => "createuser", "status" => "success");
	}
	else {
		$Response['response'][] = array( "request" => "createuser", "status" => "fail");
	}
}

//---------------------\\
//-- Create Location --\\
//---------------------\\

else if($_POST['action'] == "createlocation"){
	if($_POST['room'] != "" && $_POST['PID'] != "") {
		$room = $_POST['room'];
		$PID = $_POST['PID'];
		mysqli_query($con, "INSERT INTO `inkstock`.`departments` (`DID`, `Room`, `PID` ) 
		VALUES (NULL, '$room', '$PID' );") or die ('Unable to execute query. '. mysqli_error($con));
		$Response['response'][] = array( "request" => "createlocation", "status" => "success");
	}
	else {
		$Response['response'][] = array( "request" => "createlocation", "status" => "fail");
	}
}

else {
$Response['response'][] = array( "request" => "invalid", "status" => "fail");
}
}
else {
$Response['response'][] = array( "request" => "none", "status" => "fail");
}

}
else {
$Response['response'][] = array( "request" => "Requires Admin Permissions", "status" => "fail");
}

echo json_encode($Response, JSON_PRETTY_PRINT);
