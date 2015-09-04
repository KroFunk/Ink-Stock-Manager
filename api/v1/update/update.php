<?PHP
require "../config/config.php";
require "../config/authcheck.php";

$Response['operation'] = "update";
$Response['response'] = array();
if(isset($_POST['action'])){
if($_SESSION['IsAdmin'] == 1) {
if($_POST['action'] == "updatestock"){

     
     if(is_numeric($_POST['IID'])) {
     
     if($_POST['PID'] != "") {
     $PID = "`PID` = '" . $_POST['PID'] . "', ";
     }
     if($_POST['inkname'] != "") {
     $inkname = "`InkName` = '" . $_POST['inkname'] . "', ";
     }
     if($_POST['price'] != "") {
     $price = "`Price` = '" . $_POST['price'] . "', ";
     }
     if($_POST['stock'] != "") {
     $stock = "`Stock` = '" . $_POST['stock'] . "', ";
     }
     if($_POST['stockwarning'] != "") {
     $stockwarning = "`StockWarning` = '" . $_POST['stockwarning'] . "', ";
     }
     if($_POST['stockdefault'] != "") {
     $stockdefault = "`StockDefault` = '" . $_POST['stockdefault'] . "', ";
     }
     if($_POST['orderurl'] != "") {
     $orderurl = "`OrderURL` = '" . $_POST['orderurl'] . "', ";
     }
     if($_POST['onorder'] != "") {
     $onorder = "`OnOrder` = '" . $_POST['onorder'] . "', ";
     }
     if($_POST['UPC'] != "") {
     $UPC = "`UPC` = '" . $_POST['UPC'] . "', ";
     }
     
     $querystring = substr($PID . $inkname . $price . $stock . $stockwarning . $stockdefault . $orderurl . $onorder . $UPC, 0, -2);
     $IID = $_POST['IID'];
     
     
     mysqli_query($con, "UPDATE `inkstock`.`stock` SET " . $querystring . " WHERE `stock`.`IID` = $IID;") or die ('Unable to execute query. '. mysqli_error($con));
     
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
     
     
     mysqli_query($con, "UPDATE `inkstock`.`printers` SET " . $querystring . " WHERE `printers`.`PID` = $PID;") or die ('Unable to execute query. '. mysqli_error($con));
     
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
     
     
     mysqli_query($con, "UPDATE `inkstock`.`users` SET " . $querystring . " WHERE `users`.`UserID` = $UserID;") or die ('Unable to execute query. '. mysqli_error($con));
     
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
     
     
     mysqli_query($con, "UPDATE `inkstock`.`departments` SET " . $querystring . " WHERE `departments`.`DID` = $DID;") or die ('Unable to execute query. '. mysqli_error($con));
     
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
