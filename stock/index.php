<?PHP
require "../config/config.php";
?>
<!DOCTYPE html>
<HTML>
<head>
<title>Stock Manager | Admin | &copy; Robin Wright 2014</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<link href='../admin.css' rel='stylesheet' type='text/css'>
<!--<link href='../demo_table.css' rel='stylesheet' type='text/css'>-->
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
        Populate(myArr);
        //console.debug(myArr);
    }
}
xmlhttp.open("GET", url, true);
xmlhttp.send();

function isOdd(x) { return x & 1; };

function Colouring(Stock, Ideal, OnOrder) {
if (Stock < Ideal) {
if (OnOrder > 0) {
var Colour = "rgb(248, 216, 4)";
}
else {
var Colour = "rgb(247, 91, 104)";
}
}
else if (OnOrder > 0) {
var Colour = "rgb(18, 187, 5)";
}
else {
var Colour = "";
}
return Colour;
}

function Populate(arr) {
var out = "";
var i;
var odds = 0;
var x = 1;
var LastPrinter;
var Rows;
var RowCount = 0;
var TotalStock = 0;
var TotalProducts = 0;
var TotalValue = 0;
var TotalOnOrder = 0;
var table = document.getElementById("displaydata");
for(i = 0; i < arr.data.length; i++) {
Rows = document.getElementById("displaydata").getElementsByTagName("tr").length;
if (LastPrinter != arr.data[i]['Printer']){
var row = table.insertRow(Rows - 1);
row.id = RowCount;
RowCount++;
row.className = "group";
var cell1 = row.insertCell(0);
cell1.innerHTML = arr.data[i]['Printer'];
cell1.colSpan = 10;
Rows = document.getElementById("displaydata").getElementsByTagName("tr").length;
odds = 0;
}

// Create an empty <tr> element and add it to the 1st position of the table:
var row = table.insertRow(Rows - 1);
row.style.backgroundColor = Colouring(arr.data[i]['Stock'], arr.data[i]['StockDefault'], arr.data[i]['OnOrder']);
row.id = RowCount;
RowCount++;

if (isOdd(odds) == 1) {
row.className += "odd";
}
else {
row.className += "even";
}
odds++;


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
//var cell11 = row.insertCell(10);

// Add some text to the new cells:
cell1.innerHTML = arr.data[i]['InkName'];
cell2.innerHTML = arr.data[i]['Price'];
cell3.innerHTML = arr.data[i]['Stock'];
cell4.innerHTML = "<?php echo $Currency ?>" + (arr.data[i]['Price'] * arr.data[i]['Stock']).toFixed(2);
cell5.innerHTML = arr.data[i]['OnOrder'];
cell6.innerHTML = '<div class="centre"><a href="javascript:popout(' + arr.data[i]['OrderURL'] + ')"><img src="../icns/order.png"></a></div>';
//cell7.innerHTML = //Spacing Cell
cell8.innerHTML = '<div class="centre"><a href="javascript:openwrapper(' + "'editstock.php?index=" + arr.data[i]['IID'] + "','920','320'" + ')"><img src="../icns/edit.png"></a></div>';
cell9.innerHTML = '<div class="centre"><a href="javascript:openwrapper(' + "'auditview.php?index=" + arr.data[i]['InkName'] + "','920','320'" + ')"><img src="../icns/audit.png"></a></div>';
cell10.innerHTML = '<div class="centre"><a href="javascript:openwrapper(' + "'addstock.php?index=" + arr.data[i]['IID'] + "','920','320'" + ')"><img src="../icns/plus.png"></a>&nbsp;' + '&nbsp;<a href="javascript:openwrapper(' + "'removestock.php?index=" + arr.data[i]['IID'] + "','920','320'" + ')"><img src="../icns/minus.png"></a></div>';


TotalStock = (parseInt(TotalStock) + parseInt(arr.data[i]['Stock']));
TotalProducts++;
TotalValue = TotalValue + (arr.data[i]['Price'] * arr.data[i]['Stock']);
TotalOnOrder = TotalOnOrder + parseInt(arr.data[i]['OnOrder']);


LastPrinter = arr.data[i]['Printer'];

    } 
    
    
//Now that the table has been drawn, add the event listener for highlighting
for(i = 0; i < (document.getElementById('displaydata').getElementsByTagName("tr").length - 2); i++) {
if (document.getElementById(i).className != "group") {
document.getElementById(i).onclick = function(){highlightRow(this.rowIndex - 1);};
}

//Update Subheader       
document.getElementById('SubHeader').innerHTML = TotalProducts + ' products, ' + TotalStock + ' in stock with a value of &pound;' + TotalValue.toFixed(2) + '. ' + TotalOnOrder + ' On Order.';

       
}
    
}



$(window).load(function(){
var $rows = $('#displaydata tr');
$('#search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    
    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
});



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

<div style="float:right; width:200px; text-align:right;"><input type="text" id="search" placeholder="Type to search"></div>

<div class='dataScreenOptimised'>
<table id="displaydata" class="display" cellpadding="5" celspacing="0" width="100%" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td style="width:35%;">Ink Name</td><td width="100px">Price</td><td width="120px">Stock</td><td width="100px">Value</td><td width="65px"><center>On Order</center><td width="45px">Order</td><td></td><td width="40px"><center>Edit</center></td></td><td width="60px"><center>History</center></td><td width="55px">Update</td></tr>
</thead>

<tfoot>
<tr><td colspan="4" style="text-align:right" rowspan="1"></td><td rowspan="1" colspan="4" style="text-align:left;" ></td></tr>
</tfoot>
</table>



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
<div id='grey' style="display: none;" onclick="closewrapper();">&nbsp;</div>

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