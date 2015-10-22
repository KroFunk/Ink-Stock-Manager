<?PHP

require "../config/config.php";
?>

<HTML>
<head>
<title>Stock Manager | Admin | &copy; Robin Wright 2014</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<link href='../admin.css.php' rel='stylesheet' type='text/css'>
<link href='../demo_table.css' rel='stylesheet' type='text/css'>
<script type="text/javascript">
function popout(url){
var popup=window.open(url,"Stock Manager Popup","width=700,height=650,scrollbars=1,resizable=1,addressbar=0")
}
</script>

<script>
function openwrapper(url){
document.getElementById('iframewrapper').style.display='block'; 
document.getElementById('grey').style.display='block';
 document.getElementById('Iframe').src = url;
}
</script>

<script type="text/javascript" src="../incs/jquery.min.js"></script>

<script type="text/javascript" src="../incs/jquery.dataTables.nightly.js"></script>


<script>
$(document).ready(function() {
    $('#example').dataTable( {
    "columnDefs": [
    { "orderData": [ 0, 1 ],    "targets": 0 }
    ],
    "bPaginate": false,
	"bAutoWidth": false,
} );
} );
</script>





</head>
<body style="margin:0px; padding:0px;">
<img src="../incs/blur.jpg" class="bg" />
<div class="tablescroll dataScreenOptimised" id="tablescroll" style="display:none;">
<table class="display" cellpadding="5" celspacing="0" width="100%" style="width:100%;">
<tr style='background-color:#666; color:#eee;'><td style="width:250px;">Email Address</td><td>Name</td><td>Administrator</td><td>Mailings</td><td>Edit</td><td>Password</td><td>Delete</td></tr>
</table>
</div>



<?PHP
echo "<div id='menu'>";
include "../incs/menu.inc";
echo "</div>";


if (isset($_POST['I5'])) {
echo "old method, please use new add function.";
}

?>
<div class='HeaderBanner'>Manage users <img src="../icns/question.png" /><div id="SubHeader" class='SubHeaderBanner'>Loading, please wait...</div></div>
<div class="main" onmouseover="Hide('ReportsMenu')" >
<!--
Server message would go here!
-->
<div>

<div class='function'>
<a class="function wrapper" href="javascript:openwrapper('addnew.php')"><img src="../icns/new.png"/> Add New User</a>
<a class="function refresh" href="javascript:location.reload();"><img src="../icns/refresh.png"/> Refresh!</a>
</div>
<table id="example" class="display" cellpadding="5" celspacing="0" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td style="width:250px;">Email Address</td><td>Name</td><td>Administrator</td><td>Mailings</td><td>Edit</td><td>Password</td><td>Delete</td></tr>
</thead>
<tbody>
<?PHP
$result = mysqli_query($con, "SELECT * FROM users");

$Administrators = 0;
$Users = 0;


while($row = mysqli_fetch_array($result))
  {
  $Users++;
  
  
 echo "<tr><td>" . $row['Email'] . "</td>
 <td>" . $row['Name'] . "</td>
 <td>";
 
 if ($row['Admin'] == True){
 echo "Yes";
 }
 else {
 echo "No";
 }
 
 echo "
 </td>
 <td>";
 
  if ($row['Mail'] == True){
 echo "Yes";
 }
 else {
 echo "No";
 }
 
 echo "</td><td><center>
 <a href='" . 'javascript:openwrapper("edituser.php?name=' . $row['Name'] . '&amp;userid=' . $row['UserID'] . '")' . "'><img src='../icns/edit.png'/></a></td>
<td><center> <a href='" . 'javascript:openwrapper("resetpassword.php?name=' . $row['Name'] . '&amp;userid=' . $row['UserID'] . '")' . "'><img src='../icns/padlock.png'/></a></td>
<td><center> <a href='" . 'javascript:openwrapper("deleteuser.php?Name=' . $row['Name'] . '&amp;UserID=' . $row['UserID'] . '")' . "'><img src='../icns/delete.png'/></a></center></td>
</tr>";
  }
  
  
  
  if ($Users != 1) {
$UsersLang = "entries";
}
else {
$UsersLang = "entry";
}

if ($Administrators != 1) {
$AdministratorsLang = "items";
}
else {
$AdministratorsLang = "item";
}

  echo 
"<script>
window.onload = function(updatesubheader) {
document.getElementById('SubHeader').innerHTML = '$Entries $EntriesLang. $Removed $RemovedLang removed, $Added $AddedLang added.';
}
</script>"

?>
</tbody>
<tfoot>
<tr><td colspan="4">&nbsp;</td></tr>
</tfoot>
</table>
</div>
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
############################# Iframe Section ##############################
###########################################################################
-->


<div id="grey" style="background:#000; width:2000; height:2000; position:fixed; left:-5; top:-5; opacity:0.3; display:none;">&nbsp;</div>
<div id="iframewrapper" style="background-color: rgb(255, 255, 255); box-shadow: rgb(0, 0, 0) 0px 0px 20px; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom-right-radius: 10px; border-bottom-left-radius: 10px; position: fixed; z-index: 999999; width: 500px; height: 250px; left: 50%; margin-left: -250px; top: 50%; margin-top: -125px; display: none; background-position: initial initial; background-repeat: initial initial;"><a href="javascript:void(0);" onclick="javascript:location.reload();">
<img src="../icns/X.png" style="position:relative; top:-5px; left:490px; border:0 none;"></a>

<div style="clear:both; padding:20px; padding-left:0px; margin-top:-50px;">

<iframe id="Iframe" style="margin:10px; height:490px; width:100%;" border="0" frameborder="0"></iframe>

</div>

</div>
 
     
</body>
</HTML>