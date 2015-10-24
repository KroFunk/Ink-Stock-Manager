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
		document.getElementById("debugging").innerHTML=arr.data[0]['Printer'];

}
</script>
</head>
<body>
<div id="InfoOptions"></div>
<h1 id='title'>Edit<?php echo $InkName; ?></h1>
            InkName<br/>
            Price<br/>
            StockWarning<br/>
            StockDefault<br/>
            Stock<br/>
            ProductCode<br/>
            Description<br/>
            OnOrder<br/>
            OrderURL<br/>
            UPC<br/>
            PID<br/>
<div id='debugging'></div>
</body>
</html>