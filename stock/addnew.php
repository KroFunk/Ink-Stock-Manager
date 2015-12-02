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
<link href='../adminwhite.css' rel='stylesheet' type='text/css'>
<title>New Stock</title>
<script>

function hidePrinterList() {
        document.getElementById("printerlist").style.display='none';
}
function updatePrinter(pid,printerName) {
	document.getElementById("printer").value=printerName;
	document.getElementById("pid").value=pid;
	hidePrinterList();
}

function addstock() {

//IID is auto incremented
var PID = document.getElementById("pid").value;
var InkName = document.getElementById("inkname").value;
var Price = document.getElementById("price").value;
var Stock = '0';
var StockWarning = document.getElementById("stockwarning").value;
var StockDefault = document.getElementById("stockdefault").value;
var ProductCode = document.getElementById("productcode").value;
var Description = document.getElementById("description").value;
var OrderURL = document.getElementById("orderurl").value;
var OnOrder = '0';
var UPC = document.getElementById("UPC").value;
var xmlhttp = new XMLHttpRequest();
var url = "<?php echo $Location; ?>/api/v1/create/create.php";

xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var myArr = JSON.parse(xmlhttp.responseText);
        //console.debug(myArr);
        parent.document.getElementById("InfoOptions").innerHTML="<div class='servermessage'>" + InkName + " has been added. Refreshing data.</div>";
        parent.closewrapper();
    }
}
xmlhttp.open("POST", url, true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("action=createstock&PID=" + PID + "&inkname=" + InkName + "&price=" + Price + "&stock=" + Stock + "&stockwarning=" + StockWarning + "&stockdefault=" + StockDefault + "&productcode=" + ProductCode + "&description=" + Description + "&orderurl=" + OrderURL + "&onorder=" + OnOrder + "&UPC=" + UPC);
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



</script>
</head>
<body>
<div id="InfoOptions"></div>
<h1 id='title'>Add New Ink/Toner</h1>

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
	</table>
	<div style='text-align:right;'><input type='button' class='button' onclick='parent.closewrapper();' name='' value='Cancel' /><input type='button' class='submit' onclick='addstock();' name='' value='Add New' /></div>


</body>
</html>