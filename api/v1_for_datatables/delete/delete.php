<?PHP
require "../config/config.php";
require "../config/authcheck.php";

$Response['operation'] = "delete";
$Response['response'] = array();
if(isset($_POST['action'])){
if($_SESSION['IsAdmin'] == 1) {

//------------------\\
//-- Delete Stock --\\
//------------------\\

if($_POST['action'] == "deletestock"){    
	if($_POST['IID'] != ""){
		$IID = $_POST['IID'];
		mysqli_query($con, "DELETE FROM `inkstock`.`stock` WHERE `stock`.`IID` = $IID;") or die ('Unable to execute query. '. mysqli_error($con));
		$Response['response'][] = array( "request" => "deletestock", "status" => "success");
	}
	else {
		$Response['response'][] = array( "request" => "deletestock", "status" => "fail");
	}     
}

//--------------------\\
//-- Delete Printer --\\
//--------------------\\

else if($_POST['action'] == "deleteprinter"){
	if($_POST['PID'] != ""){     
		$PID = $_POST['PID'];
		mysqli_query($con, "DELETE FROM `inkstock`.`printers` WHERE `printers`.`PID` = $PID;") or die ('Unable to execute query. '. mysqli_error($con));
		$Response['response'][] = array( "request" => "deleteprinter", "status" => "success");
	}
	else {
		$Response['response'][] = array( "request" => "deleteprinter", "status" => "fail");
	}
}

//-----------------\\
//-- Delete User --\\
//-----------------\\

else if($_POST['action'] == "deleteuser"){
	if($_POST['UserID'] != "") {
		if($_SESSION['CUID'] != $_POST['UserID']) { 
			$UserID = $_POST['UserID'];  
			mysqli_query($con, "DELETE FROM `inkstock`.`users` WHERE `users`.`UserID` = $UserID;") or die ('Unable to execute query. '. mysqli_error($con));   
			$Response['response'][] = array( "request" => "createuser", "status" => "success");
		}
		else {
			$Response['response'][] = array( "request" => "deleteuser", "status" => "fail, cannot delete self.");
		}
	}
	else {
		$Response['response'][] = array( "request" => "deleteuser", "status" => "fail");
	}
}

//---------------------\\
//-- Delete Location --\\
//---------------------\\

else if($_POST['action'] == "deletelocation"){
	if($_POST['DID'] != "") {    
		$DID = $_POST['DID'];          
		mysqli_query($con, "DELETE FROM `inkstock`.`departments` WHERE `departments`.`DID` = $DID;") or die ('Unable to execute query. '. mysqli_error($con));     
		$Response['response'][] = array( "request" => "deletelocation", "status" => "success");
	}
	else {
		$Response['response'][] = array( "request" => "deletelocation", "status" => "fail");
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
