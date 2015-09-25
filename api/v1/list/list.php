<?PHP
require "../../../config/config.php";
require "../../../auth/authcheck.php";

$Response['operation'] = "list";
$Response['response'] = array();
$Response['data'] = array();

if (isset($_GET['action'])) {
//---------------------\\
//-- List DataTables --\\
//---------------------\\

if(@$_GET['action'] == "liststocktables"){
		$WHERE = "";
	$result = mysqli_query($con, "SELECT * FROM Stock LEFT JOIN Printers ON Stock.PID=Printers.PID ORDER BY Printers.PrinterMake ASC, Printers.PrinterModel ASC");
	while($row = mysqli_fetch_array($result))
	{   
	$Response['data'][] = array( "IID" => $row['IID'], 
									 "InkName" => $row['InkName'],
									 "Price" => number_format($row['Price'], 2, '.', ''),
									 "StockWarning" => $row['StockWarning'],
									 "StockDefault" => $row['StockDefault'],
									 "Stock" => $row['Stock'],
									 "ProductCode" => $row['ProductCode'],
                                     "Description" => $row['Description'],
									 "OnOrder" => $row['OnOrder'],
									 "OrderURL" => $row['OrderURL'],
									 "UPC" => $row['UPC'],
									 "PID" => $row['PID'],
									 "Printer" => $row['PrinterMake'] . " " . $row['PrinterModel']
									);  
	//	$Response['data'][] = array( 
	//								 $row['PrinterMake'] . " " . $row['PrinterModel'] . " (" . $row['Type'] . ")",
	//								 $row['InkName'],
	//								 '&pound;' . number_format($row['Price'], 2, '.', ''),
	//								 $row['Stock'] . " (ideal: " . $row['StockDefault'] . ")",
	//								 '&pound;' . ((number_format($row['Price'], 2, '.', '')) * $row['Stock']),
	//								 $row['OnOrder'],
	//								 '<a href="javascript:popout(' . $row['OrderURL'] . ')"><img src="../icns/order.png"></a>',
	//								 " ", 
	//								 '<a href="javascript:openwrapper(' . "'editstock.php?index=" . $row['IID'] . "','920','320'" . ')"><img src="../icns/edit.png"></a>',
	//								 '<a href="javascript:openwrapper(' . "'auditview.php?index=" . $row['InkName'] . "','920','400'" . ')"><img src="../icns/audit.png"></a>',
	//								 '<a href="javascript:openwrapper(' . "'addstock.php?index=" . $row['IID'] . "','400','240'" . ')"><img src="../icns/plus.png"></a>' . 
	//								 '<a href="javascript:openwrapper(' . "'removestock.php?index=" . $row['IID'] . "','400','240'" . ')"><img src="../icns/minus.png"></a>'
	//								);    
	}
	$Response['response'][] = array( "request" => "listtables", "status" => "success");
}
}



if(isset($_POST['action'])) {

//----------------\\
//-- List Stock --\\
//----------------\\

if($_POST['action'] == "liststock"){
	if($_POST['IID'] != "") {
		$WHERE = " WHERE `stock`.`IID` =" . $_POST['IID'];
	}
	else {
		$WHERE = "";
	}
	$result = mysqli_query($con, "SELECT * FROM Stock LEFT JOIN Printers ON Stock.PID=Printers.PID $WHERE") or die ('Unable to execute query. '. mysqli_error($con));
	while($row = mysqli_fetch_array($result))
	{    
		$Response['data'][] = array( "IID" => $row['IID'], 
									 "InkName" => $row['InkName'],
									 "Price" => number_format($row['Price'], 2, '.', ''),
									 "StockWarning" => $row['StockWarning'],
									 "StockDefault" => $row['StockDefault'],
									 "Stock" => $row['Stock'],
									 "ProductCode" => $row['ProductCode'],
                                     "Description" => $row['Description'],
									 "OnOrder" => $row['OnOrder'],
									 "OrderURL" => $row['OrderURL'],
									 "UPC" => $row['UPC'],
									 "PID" => $row['PID'],
									 "Printer" => $row['PrinterMake'] . " " . $row['PrinterModel']
									);    
	}
	$Response['response'][] = array( "request" => "liststock", "status" => "success");
}


//----------------\\
//-- List Users --\\
//----------------\\

elseif($_POST['action'] == "listusers"){
if($_SESSION['IsAdmin'] == 1) {
$WHERE = "";
if(isset($_POST['admin']) or isset($_POST['notadmin']) or isset($_POST['mail']) OR isset($_POST['mail'])) {
$firstadded = 0;
if(isset($_POST['admin'])){
if($firstadded == 0){
$WHERE .= "WHERE (";
$firstadded = 1;
}
else {
$WHERE .= " OR ";
}
$WHERE .= "`Admin` = '1'";
}
if(isset($_POST['notadmin'])){
if($firstadded == 0){
$WHERE .= "WHERE (";
$firstadded = 1;
}
else {
$WHERE .= " OR ";
}
$WHERE .= "`Admin` = '0'";
}
if(isset($_POST['mail'])){
if($firstadded == 0){
$WHERE .= "WHERE (";
$firstadded = 1;
}
else {
$WHERE .= " OR ";
}
$WHERE .= "`Mail` = '1'";
}
if(isset($_POST['nomail'])){
if($firstadded == 0){
$WHERE .= "WHERE (";
$firstadded = 1;
}
else {
$WHERE .= " OR ";
}
$WHERE .= "`Mail` = '0'";
}
$WHERE .= ")";
}
if($_POST['UserID'] != "") {
if($firstadded == 0){
$WHERE .= " WHERE `UserID` = " . $_POST['UserID'];
}
else {
$WHERE .= " AND `UserID` = " . $_POST['UserID'];
}
}
$result = mysqli_query($con, "SELECT * FROM Users $WHERE") or die ('Unable to execute query. '. mysqli_error($con));
while($row = mysqli_fetch_array($result))
  {    
$Response['data'][] = array( "UserID" => $row['UserID'],
                             "Name" => $row['Name'],
                             "Email" => $row['Email'],
                             "Admin" => $row['Admin'],
                             "Mail" => $row['Mail']
                           );    
}  
$Response['response'][] = array( "request" => "listusers", "status" => "success");
}
else {
$Response['response'][] = array( "request" => "listusers", "status" => "fail");
}
}

//-------------------\\
//-- List Printers --\\
//-------------------\\

else if($_POST['action'] == "listprinters"){

$foo = 0;
$WHERE = "";
if($_POST['PID'] != "") {
     $WHERE = " WHERE `printers`.`PID` =" . $_POST['PID'];
     }

$printers = mysqli_query($con, "SELECT * FROM Printers $WHERE") or die ('Unable to execute query. '. mysqli_error($con));
while($row = mysqli_fetch_array($printers))
  {
     
     $Response['data'][$foo] = array( "PID" => $row['PID'], 
                                  "SupportLink" => $row['SupportLink'], 
                                  "Colour" => $row['Colour'], 
                                  "Media" => $row['Media'], 
                                  "Make" => $row['PrinterMake'],
                                  "Model" => $row['PrinterModel'],
                                  "Locations" => array(),
                                  "Stock" => array()
                                  );
                                  
                                  $PID = $row['PID'];
                                  $departments = mysqli_query($con, "SELECT * FROM `departments` WHERE `PID` = $PID");
								  while($departmentrow = mysqli_fetch_array($departments))
								  {
                                  array_push($Response['data'][$foo]['Locations'], array( "Location" => $departmentrow['Room'],
                                  "DID" => $departmentrow['DID'])
                                  );
                                  }
                                  $stockresult = mysqli_query($con, "SELECT * FROM Stock WHERE `PID` = '$PID'");
									while($stockrow = mysqli_fetch_array($stockresult))
  									{
     
     							  array_push($Response['data'][$foo]['Stock'], array( "IID" => $stockrow['IID'], 
                                  "InkName" => $stockrow['InkName'],
                                  "Price" => number_format($stockrow['Price'], 2, '.', ''),
                                  "StockWarning" => $stockrow['StockWarning'],
                                  "StockDefault" => $stockrow['StockDefault'],
                                  "Stock" => $stockrow['Stock'],
                                  "ProductCode" => $stockrow['ProductCode'],
                                  "Description" => $stockrow['Description'],
                                  "OnOrder" => $stockrow['OnOrder'],
                                  "OrderURL" => $stockrow['OrderURL'],
                                  "UPC" => $stockrow['UPC'])
                                  );
     
  }
                                  
                                  
     $foo++;
  }
  
  
  
$Response['response'][] = array( "request" => "listprinters", "status" => "success");
}

//----------------\\
//-- List Audit --\\
//----------------\\

else if($_POST['action'] == "listaudit"){

if(isset($_POST['fromdate']) && isset($_POST['todate']) && $_POST['fromdate'] != "" && $_POST['todate'] != ""){
$fromdate = $_POST['fromdate'];
$todate = $_POST['todate'];

$WHERE = "";

//This statement needs to be an AND OR in paranthesis. Statement built with Boolena switch...do it or fail >=)
if(isset($_POST['stockadded']) or isset($_POST['stockremoved']) or isset($_POST['stockcreated']) OR isset($_POST['stockdeleted'])) {
$firstadded = 0;
if(isset($_POST['stockadded'])){
if($firstadded == 0){
$WHERE .= "AND (";
$firstadded = 1;
}
else {
$WHERE .= " OR ";
}
$WHERE .= "`Detail` LIKE '%added%'";
}
if(isset($_POST['stockremoved'])){
if($firstadded == 0){
$WHERE .= "AND (";
$firstadded = 1;
}
else {
$WHERE .= " OR ";
}
$WHERE .= "`Detail` LIKE '%removed%'";
}
if(isset($_POST['stockcheck'])){
if($firstadded == 0){
$WHERE .= "AND (";
$firstadded = 1;
}
else {
$WHERE .= " OR ";
}
$WHERE .= "`Detail` = 'Stock Check Completed'";
}
if(isset($_POST['stockcreated'])){
if($firstadded == 0){
$WHERE .= "AND (";
$firstadded = 1;
}
else {
$WHERE .= " OR ";
}
$WHERE .= "`Detail` = 'New Product Added to System'";
}
if(isset($_POST['stockdeleted'])){
if($firstadded == 0){
$WHERE .= "AND (";
$firstadded = 1;
}
else {
$WHERE .= " OR ";
}
$WHERE .= "`Detail` = 'Product Removed From System'";
}

$WHERE .= ")";
}

$result = mysqli_query($con, "SELECT * 
FROM  `AuditTrail` INNER JOIN users ON audittrail.UserID=users.UserID
WHERE (`Date` BETWEEN '$fromdate' AND '$todate') $WHERE") or die ('Unable to execute query. '. mysqli_error($con));
while($row = mysqli_fetch_array($result))
  {
     
     $Response['data'][] = array( "AID" => $row['AID'], 
                                  "Date" => $row['Date'],
                                  "Time" => $row['Time'],
                                  "User" => $row['Name'],
                                  "Printer" => $row['Printer'],
                                  "InkName" => $row['InkName'],
                                  "Cost" => $row['Cost'],
                                  "Department" => $row['Department'],
                                  "Detail" => $row['Detail'],
                                  "Note" => $row['Note']
                                  );
                                  
  }

$Response['response'][] = array( "request" => "listaudit", "status" => "success");
}
}
else {
$Response['response'][] = array( "request" => "invalid", "status" => "fail");
}
}
else {
if(@$_GET['action'] == "listtables"){
	//nothing
}
else {
	$Response['response'][] = array( "request" => "none", "status" => "fail");
}
}
echo json_encode($Response, JSON_PRETTY_PRINT);
