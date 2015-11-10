<?PHP
require "../../../config/config.php";
require "../../../auth/authcheck.php";

$Response['operation'] = "update";
$Response['response'] = array();
if(isset($_POST['action'])){
if($_SESSION['IsAdmin'] == 1) {
$theDate = date('Y') . "-" . date('m') . "-" . date('d');
$theTime = date('H') . ":" . date('i');

if($_POST['action'] == "updatestock"){

     if(is_numeric($_POST['IID'])) {
     
     $IID = $_POST['IID'];
     $result = mysqli_query($con, "SELECT * FROM Stock WHERE `IID` = $IID");
     $current = mysqli_fetch_array($result);
     
     if($_POST['PID'] != "" && $_POST['PID'] != $current['PID']) {
     $PID = "`PID` = '" . $_POST['PID'] . "', ";
     }
     if($_POST['inkname'] != "" && $_POST['inkname'] != $current['InkName']) {
     $inkname = "`InkName` = '" . $_POST['inkname'] . "', ";
     }
     if($_POST['price'] != "" && $_POST['price'] != $current['Price']) {
     $price = "`Price` = '" . $_POST['price'] . "', ";
     }
     if($_POST['stock'] != "" && $_POST['stock'] != $current['Stock']) {
     $stock = "`Stock` = '" . $_POST['stock'] . "', ";
     }
     if($_POST['stockwarning'] != "" && $_POST['stockwarning'] != $current['StockWarning']) {
     $stockwarning = "`StockWarning` = '" . $_POST['stockwarning'] . "', ";
     }
     if($_POST['stockdefault'] != "" && $_POST['stockdefault'] != $current['StockDefault']) {
     $stockdefault = "`StockDefault` = '" . $_POST['stockdefault'] . "', ";
     }
     if($_POST['productcode'] != "" && $_POST['productcode'] != $current['ProductCode']) {
     $productcode = "`ProductCode` = '" . $_POST['productcode'] . "', ";
     }
     if($_POST['description'] != "" && $_POST['description'] != $current['Description']) {
     $description = "`Description` = '" . $_POST['description'] . "', ";
     }
     if($_POST['orderurl'] != "" && $_POST['orderurl'] != $current['OrderURL']) {
     $orderurl = "`OrderURL` = '" . $_POST['orderurl'] . "', ";
     }
     if($_POST['onorder'] != "" && $_POST['onorder'] != $current['OnOrder']) {
     $onorder = "`OnOrder` = '" . $_POST['onorder'] . "', ";
     }
     if($_POST['UPC'] != "" && $_POST['UPC'] != $current['UPC']) {
     $UPC = "`UPC` = '" . $_POST['UPC'] . "', ";
     }
     
     $querystring = substr($PID . $inkname . $price . $stock . $stockwarning . $stockdefault . $productcode . $description . $orderurl . $onorder . $UPC, 0, -2);
     
     $IID = $_POST['IID'];
     
     mysqli_query($con, "UPDATE `$SQLDB`.`stock` SET " . $querystring . " WHERE `stock`.`IID` = $IID;") or die ('Unable to execute query. '. mysqli_error($con));
     
     $result = mysqli_query($con, "SELECT * FROM Stock LEFT JOIN Printers ON Stock.PID=Printers.PID  WHERE `stock`.`IID` = $IID") or die ('Unable to execute query. '. mysqli_error($con));
     $row = mysqli_fetch_array($result);
     $printer = $row['Printer'];
	 $inkname = $row['InkName'];
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
NULL,  '$theDate',  '$theTime', '$CUID', '$printer',  '$inkname',  '-',  '-',  'Stock record was updated',  '$encodedquery'
);") or die ('Unable to execute query. '. mysqli_error($con));
     
     
     $Response['response'][] = array( "request" => "updatestock", "status" => "success");
}
else {
     $Response['response'][] = array( "request" => "updatestock", "status" => "fail");
}
         
}

else if($_POST['action'] == "updateprinter"){

 if(is_numeric($_POST['PID'])) {
     
     if($_POST['printermake'] != "") {
     $printermake = "`PrinterMake` = '" . $_POST['printermake'] . "', ";
     }
     if($_POST['printermodel'] != "") {
     $printermodel = "`PrinterModel` = '" . $_POST['printermodel'] . "', ";
     }
     if($_POST['supportlink'] != "") {
     $supportlink = "`SupportLink` = '" . $_POST['supportlink'] . "', ";
     }
     if($_POST['colour'] != "") {
     $colour = "`Colour` = '" . $_POST['colour'] . "', ";
     }
     if($_POST['media'] != "") {
     $media = "`Media` = '" . $_POST['media'] . "', ";
     }
     if($_POST['type'] != "") {
     $type = "`Type` = '" . $_POST['type'] . "', ";
     }
     
     $querystring = substr($printermake . $printermodel . $supportlink . $colour . $media . $type, 0, -2);
     $PID = $_POST['PID'];
     
     
     mysqli_query($con, "UPDATE `$SQLDB`.`printers` SET " . $querystring . " WHERE `printers`.`PID` = $PID;") or die ('Unable to execute query. '. mysqli_error($con));
     
     $Response['response'][] = array( "request" => "updateprinter", "status" => "success");
}
else {
     $Response['response'][] = array( "request" => "updateprinter", "status" => "fail");
}

}

else if($_POST['action'] == "updateuser"){
if($_SESSION['IsAdmin'] == 1) {
 if(is_numeric($_POST['UserID'])) {
     
     if($_POST['name'] != "") {
     $name = "`Name` = '" . $_POST['name'] . "', ";
     }
     if($_POST['email'] != "") {
     $email = "`Email` = '" . $_POST['email'] . "', ";
     }
     if($_POST['admin'] != "") {
     $admin = "`Admin` = '" . $_POST['admin'] . "', ";
     }
     if($_POST['mail'] != "") {
     $mail = "`Mail` = '" . $_POST['mail'] . "', ";
     }
     if($_POST['password'] != "") {
     $password = "`Password` = '" . password_hash($_POST['password'], PASSWORD_DEFAULT) . "', ";
     }
     
     
     $querystring = substr($name . $email . $admin . $mail . $password, 0, -2);
     $UserID = $_POST['UserID'];
     
     
     mysqli_query($con, "UPDATE `$SQLDB`.`users` SET " . $querystring . " WHERE `users`.`UserID` = $UserID;") or die ('Unable to execute query. '. mysqli_error($con));
     
     $Response['response'][] = array( "request" => "updateuser", "status" => "success");
}
else {
     $Response['response'][] = array( "request" => "updateuser", "status" => "fail");
}
}
else {
     $Response['response'][] = array( "request" => "updateuser", "status" => "fail");
}
}

else if($_POST['action'] == "updatelocation"){

 if(is_numeric($_POST['DID'])) {
     
     if($_POST['room'] != "") {
     $room = "`Room` = '" . $_POST['room'] . "', ";
     }
     if($_POST['PID'] != "") {
     $PID = "`PID` = '" . $_POST['PID'] . "', ";
     }
     
     $querystring = substr($room . $PID, 0, -2);
     $DID = $_POST['DID'];
     
     
     mysqli_query($con, "UPDATE `$SQLDB`.`departments` SET " . $querystring . " WHERE `departments`.`DID` = $DID;") or die ('Unable to execute query. '. mysqli_error($con));
     
     $Response['response'][] = array( "request" => "updatelocation", "status" => "success");
}
else {
     $Response['response'][] = array( "request" => "updatelocation", "status" => "fail");
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
