<?PHP
require "../config/config.php";
?>
<!DOCTYPE html>
<HTML>
<head>
<title>Stock Manager | Admin | &copy; Robin Wright 2014</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<link href='../admin.css' rel='stylesheet' type='text/css'>
<link href='../demo_table.css' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="../incs/robins.iframe.wrapper.js"></script>
<script type="text/javascript" src="../incs/jquery.min.js"></script>


<script>
window.onload = function PopulateData() {   






}

var xmlhttp = new XMLHttpRequest();
var url = "<?php echo $Location; ?>/api/v1/list/list.php?action=liststocktables";

xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var myArr = JSON.parse(xmlhttp.responseText);
        myFunction(myArr);
        //console.debug(myArr);
    }
}
xmlhttp.open("GET", url, true);
xmlhttp.send();
    
function myFunction(arr) {
var out = "";
var i;
var x;
var table = document.getElementById("displaydata");
for(i = 0; i < arr.data.length; i++) {
x = i + 1;

// Create an empty <tr> element and add it to the 1st position of the table:
var row = table.insertRow(x);

// Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
var cell1 = row.insertCell(0);
var cell2 = row.insertCell(1);
var cell3 = row.insertCell(2);
var cell4 = row.insertCell(3);
var cell5 = row.insertCell(4);
var cell6 = row.insertCell(5);
var cell7 = row.insertCell(6);
var cell8 = row.insertCell(7);
var cell9 = row.insertCell(8);
var cell10 = row.insertCell(9);
var cell11 = row.insertCell(10);

// Add some text to the new cells:
cell1.innerHTML = arr.data[i][0];
cell2.innerHTML = arr.data[i][1];
cell3.innerHTML = arr.data[i][2];
cell4.innerHTML = arr.data[i][3];
cell5.innerHTML = arr.data[i][4];
cell6.innerHTML = arr.data[i][5];
cell7.innerHTML = arr.data[i][6];
cell8.innerHTML = arr.data[i][7];
cell9.innerHTML = arr.data[i][8];
cell10.innerHTML = arr.data[i][9];
cell11.innerHTML = arr.data[i][10];
    }
}
</script>
</head>
<body style="margin:0px; padding:0px;">
<img src="../incs/blur.jpg" class="bg" />

<div class="tablescroll dataScreenOptimised" id="tablescroll" style="display:none;">
<table class="display" cellpadding="5" celspacing="0" width="100%" style="width:100%;">
<tr style='background-color:#666; color:#eee;'><td style="width:35%;">Ink Name</td><td style="width:100px">Price</td><td style="width:120px">Stock</td><td style="width:100px">Value</td><td style="width:65px"><center>On Order</center><td style="width:45px">Order</td><td></td><td style="width:40px"><center>Edit</center></td></td><td style="width:60px"><center>History</center></td><td style="width:55px">Update</td></tr>
</table>
</div>



<?PHP
//echo "<div id='menu'>";
include "../incs/menu.inc";
//echo "</div>";
?>
<div class='HeaderBanner'>Stock <img src="../icns/question.png" /><div id="SubHeader" class='SubHeaderBanner'><b>Loading, please wait...</b></div></div>
<div class="main" onmouseover="Hide('ReportsMenu')" >
<!--
Server message would go here!
-->
<div>

<div class='function'>
<a class="function wrapper" href="javascript:openwrapper('addnew.php', '800', '220')"><img src="../icns/new.png"/> Add New Ink/Toner</a>
<a class="function refresh" href="javascript:location.reload();"><img src="../icns/refresh.png"/> Refresh!</a>
<a class="function wrapper" href="javascript:openwrapper('scanin.php', '640', '420')"><img src="../icns/UPC.png"/> Scan Stock In</a>
<a class="function wrapper" href="javascript:openwrapper('scanout.php', '640', '420')"><img src="../icns/UPC.png"/> Scan Stock Out</a>
</div>

<div class='dataScreenOptimised'>
<table id="displaydata" class="display" cellpadding="5" celspacing="0" width="100%" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td>Printer</td><td style="width:35%;">Ink Name</td><td width="100px">Price</td><td width="120px">Stock</td><td width="100px">Value</td><td width="65px"><center>On Order</center><td width="45px">Order</td><td></td><td width="40px"><center>Edit</center></td></td><td width="60px"><center>History</center></td><td width="55px">Update</td></tr>
</thead>

<tfoot>
<tr><td colspan="4" style="text-align:right" rowspan="1">Showing:</td><td rowspan="1" colspan="4" style="text-align:left;" >Loading</td></tr>
</tfoot>
</table>


<?php //echo 
"<script>
window.onload = function(updatesubheader) {
document.getElementById('SubHeader').innerHTML = 'ProductCount products, StockCount in stock with a value of &pound;StockValue. OrderCount On Order.';
}
</script>"
?>



<p style="margin:0px;padding:0px;clear:both;text-align:center;"></p>
</div>
<p style="margin:0px;padding:0px;clear:both;text-align:center;"></p>
</div>
<p style="margin:0px;padding:0px;clear:both;text-align:center;"></p>
</div>

<?PHP
mysqli_close($con);
?>


<div class="footerfill"></div>

<?php include "../incs/footer.inc"; ?>

<p style="margin:0px;padding:0px;clear:both;text-align:center;"></p>

</div>
</div>



<!--
###########################################################################
######################### Iframe Section  Start ###########################
###########################################################################
-->

<!-- Grey out background -->
<div id="grey" style="display:none;" onclick="closewrapper();">&nbsp;</div>

<!-- The white box that the window will reside in -->
<div id="iframewrapper" style="width: 750px; height: 230px; margin-left: -375px; margin-top: -95px; display: none;">

<!-- The 'X' button -->
<a href="javascript:void(0);" onclick="closewrapper();">
<img id="iframeX" src="../icns/X.png" style="position:relative; top:-10px; left:735px; border:0 none;">
</a>

<!-- Actual iFrame container -->
<div style="clear:both; padding:20px; padding-left:0px; margin-top:-50px;">
<iframe id="Iframe" style="margin:10px; height:220px; width:100%;" border="0" frameborder="0"></iframe>
</div>

</div>
 
<!--
###########################################################################
########################## Iframe Section  End ############################
###########################################################################
-->
     
</body>
</HTML>