<?PHP

require "../config/config.php";
$index = "";
if (isset($_GET['index'])) {$index = $_GET['index'];}
$InkName = "";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link href='../adminwhite.css?id=1' rel='stylesheet' type='text/css'>
<title>Edit Stock</title>
<script>
window.onload = function InitialRefesh() {   
PopulateData();
}
function PopulateData() {

var xmlhttp = new XMLHttpRequest();
var url = "<?php echo $Location; ?>/api/v1/list/list.php";

xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var myArr = JSON.parse(xmlhttp.responseText);
        Populate(myArr);
        //console.debug(myArr);
    }
}
xmlhttp.open("POST", url, true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("action=liststock&IID=<?php echo $index; ?>");
}
function Populate(arr) {
	document.getElementById("title").innerHTML="Edit "+arr.data[0]['InkName']+" <span style='font-size:12px;'>(for "+arr.data[0]['Printer']+")</span>";
	document.getElementById("printer").value=arr.data[0]['Printer'];
	document.getElementById("pid").value=arr.data[0]['PID'];
	document.getElementById("inkname").value=arr.data[0]['InkName'];
	document.getElementById("price").value=arr.data[0]['Price'];
	document.getElementById("stockwarning").value=arr.data[0]['StockWarning'];
	document.getElementById("stockdefault").value=arr.data[0]['StockDefault'];
	document.getElementById("productcode").value=arr.data[0]['ProductCode'];
	document.getElementById("description").value=arr.data[0]['Description'];
	document.getElementById("orderurl").value=arr.data[0]['OrderURL'];
	document.getElementById("UPC").value=arr.data[0]['UPC'];
}

function hidePrinterList() {
        document.getElementById("printerlist").style.display='none';
}
function updatePrinter(pid,printerName) {
	document.getElementById("printer").value=printerName;
	document.getElementById("pid").value=pid;
	hidePrinterList();
}

function editstock() {
var PID = document.getElementById("pid").value;
var InkName = document.getElementById("inkname").value;
var Price = document.getElementById("price").value;
var StockWarning = document.getElementById("stockwarning").value;
var StockDefault = document.getElementById("stockdefault").value;
var ProductCode = document.getElementById("productcode").value;
var Description = document.getElementById("description").value;
var OrderURL = document.getElementById("orderurl").value;
var UPC = document.getElementById("UPC").value;
var xmlhttp = new XMLHttpRequest();
var url = "<?php echo $Location; ?>/api/v1/update/update.php";

xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var myArr = JSON.parse(xmlhttp.responseText);
        //Populate(myArr);
        //alert("action=updatestock&PID=" + PID + "&inkname=" + InkName + "&=price" + Price + "&=stockwarning" + StockWarning + "&=stockdefault" + StockDefault + "&=productcode" + ProductCode + "&=description" + Description + "&=orderurl" + OrderURL + "&=UPC" + UPC + "&IID=<?php echo $index; ?>");
        //console.debug(myArr);
        parent.document.getElementById("InfoOptions").innerHTML="<div class='servermessage'>" + InkName + " updated. Refreshing data.</div>";
        parent.closewrapper();
    }
}
xmlhttp.open("POST", url, true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("action=updatestock&PID=" + PID + "&inkname=" + InkName + "&price=" + Price + "&=stockwarning" + StockWarning + "&stockdefault=" + StockDefault + "&productcode=" + ProductCode + "&description=" + Description + "&orderurl=" + OrderURL + "&UPC=" + UPC + "&IID=<?php echo $index; ?>");
}


function showprinterlist() {
	document.getElementById("printerlist").innerHTML='<div class="ListItem" onclick="hidePrinterList();">' + document.getElementById("printer").value + ' (Currently selected)</div>';
var xmlhttp = new XMLHttpRequest();
var url = "<?php echo $Location; ?>/api/v1/list/list.php";

xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var myArr = JSON.parse(xmlhttp.responseText);
        
        //console.debug(myArr);
        var i;
        for(i = 0; i < myArr.data.length; i++)  {
        document.getElementById("printerlist").style.display='block';
        document.getElementById("printerlist").innerHTML=document.getElementById("printerlist").innerHTML + '<div class="ListItem" onclick="updatePrinter(' + myArr.data[i]['PID'] + ', ' + "'" + myArr.data[i]['Make'] + ' ' + myArr.data[i]['Model'] + "'" + ');">' + myArr.data[i]['Make'] + ' ' + myArr.data[i]['Model'] + '</div>';
        }
    }
}
xmlhttp.open("POST", url, true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("action=listprinters");
}

function deleteWarning () {
IID = <?php echo $index; ?>;
inkName = document.getElementById("inkname").value;
wrapperContent = document.getElementById("wrapper").innerHTML;
console.debug(wrapperContent);
document.getElementById("wrapper").innerHTML = "<div style='text-align:center; margin-top:50px;'><h2>Are you sure you want to delete " + inkName + "?</h2><input type='button' class='button' onclick='deleteCancel();' name='' value='Cancel' /><input type='button' class='delete' onclick='deleteConfirm(`" + inkName + "`);' name='' value='Delete' />";
}

function deleteCancel () {
console.debug('Delete Cancelled');
document.getElementById("wrapper").innerHTML = wrapperContent;
PopulateData();
}

function deleteConfirm (InkName) {
var xmlhttp = new XMLHttpRequest();
var url = "<?php echo $Location; ?>/api/v1/update/update.php";

xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var myArr = JSON.parse(xmlhttp.responseText);
        //Populate(myArr);
        //alert("action=updatestock&PID=" + PID + "&inkname=" + InkName + "&=price" + Price + "&=stockwarning" + StockWarning + "&=stockdefault" + StockDefault + "&=productcode" + ProductCode + "&=description" + Description + "&=orderurl" + OrderURL + "&=UPC" + UPC + "&IID=<?php echo $index; ?>");
        //console.debug(myArr);
        parent.document.getElementById("InfoOptions").innerHTML="<div class='servermessage'>" + InkName + " deleted. Refreshing data.</div>";
        parent.closewrapper();
    }
}
xmlhttp.open("POST", url, true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("action=updatestock&deleted=1&IID=<?php echo $index; ?>");
}

</script>
</head>
<body>
<div id='wrapper'>
<div id="InfoOptions"></div>
<h1 id='title'>Edit<?php echo $InkName; ?></h1>

<div style='display:none; position:absolute; z-index:999; width:240px; height:195px; overflow-y:scroll; overflow-x:hidden; background:white; border:1px solid #ccc; box-shadow: 2px 2px 5px #000; top:100px; left:5px;' id='printerlist'></div>
			
	<table style='width:100%;margin-bottom:10px;' cellspacing='0' cellpadding='5'>
	<thead>
	<tr style="background-color:#666; color:#eee;">
	<td style='width:220px;'>Printer</td><td style='width:200px;'>Ink Name</td><td>Price</td><td>Stock Warning</td><td>Stock Default</td>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td><input type='hidden' id='pid' name='pid' /><input onclick='showprinterlist();' style='width:200px;' type='text' id='printer' name='printer' /></td><td><input style='width:180px;' type='text' id='inkname' name='inkname' /></td><td><input style='width:115px;' type='text' id='price' name='price' value='<?php echo $Currency; ?>' /></td><td><input style='width:115px;' type='text' id='stockwarning' name='stockwarning' /></td><td><input style='width:115px;' type='text' id='stockdefault' name='stockdefault' /></td>
	</tr>
	</tbody>
	</table>
	
	<table style='width:100%;margin-bottom:10px;' cellspacing='0' cellpadding='5'>
	<thead>
	<tr style="background-color:#666; color:#eee;">
	<td>Product Code</td><td>Description</td><td>OrderURL</td><td>UPC</td>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td><input style='width:190px;' type='text' id='productcode' name='productcode' /></td><td><input style='width:190px;' type='text' id='description' name='description' /></td><td><input style='width:190px;' type='text' id='orderurl' name='orderurl' /></td><td><input style='width:190px;' type='text' id='UPC' name='UPC' /></td>
	</tr>
	</tbody>
	</table><div style='float:left;'><input type='button' class='delete' onclick='deleteWarning();' name='' value='Delete' /></div>
	<div style='text-align:right;'><input type='button' class='button' onclick='parent.closewrapper();' name='' value='Cancel' /><input type='button' class='submit' onclick='editstock();' name='' value='Update' /></div>
</div>

</body>
</html>