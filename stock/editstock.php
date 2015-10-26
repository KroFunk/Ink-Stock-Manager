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
	document.getElementById("inkname").value=arr.data[0]['InkName'];
	document.getElementById("price").value=arr.data[0]['Price'];
	document.getElementById("stockwarning").value=arr.data[0]['StockWarning'];
	document.getElementById("stockdefault").value=arr.data[0]['StockDefault'];
	document.getElementById("productcode").value=arr.data[0]['ProductCode'];
	document.getElementById("description").value=arr.data[0]['Description'];
	document.getElementById("orderurl").value=arr.data[0]['OrderURL'];
	document.getElementById("UPC").value=arr.data[0]['UPC'];
}
</script>
</head>
<body style="background-color:#ccc;">
<div id="InfoOptions"></div>
<h1 id='title'>Edit<?php echo $InkName; ?></h1>
			
	<table style='width:100%;margin-bottom:25px;' cellspacing='0' cellpadding='5'>
	<thead>
	<tr style="background-color:#666; color:#eee;">
	<td>Ink Name</td><td>Price</td><td>Stock Warning</td><td>Stock Default</td>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td><input type='text' id='inkname' name='inkname' /></td><td><input type='text' id='price' name='price' value='<?php echo $Currency; ?>' /></td><td><input type='text' id='stockwarning' name='stockwarning' /></td><td><input type='text' id='stockdefault' name='stockdefault' /></td>
	</tr>
	</tbody>
	</table>
	
	<table style='width:100%;margin-bottom:25px;' cellspacing='0' cellpadding='5'>
	<thead>
	<tr style="background-color:#666; color:#eee;">
	<td>Product Code</td><td>Description</td><td>OrderURL</td><td>UPC</td>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td><input type='text' id='productcode' name='productcode' /></td><td><input type='text' id='description' name='description' /></td><td><input type='text' id='orderurl' name='orderurl' /></td><td><input type='text' id='UPC' name='UPC' /></td>
	</tr>
	</tbody>
	</table>
	<div style='text-align:right;'><input type='button' name='' value='Cancel' /><input type='submit' name='' value='Update' /></div>


</body>
</html>