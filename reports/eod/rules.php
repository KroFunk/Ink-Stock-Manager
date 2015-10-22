<?PHP

require "../../config/config.php";
if (isset($_GET['fromdate'])){
$fromdate = $_GET['fromdate'];
}
else {
$fromdate = date('Y') . '-' . date('m') . '-01';
}
if (isset($_GET['todate'])){
$todate = $_GET['todate'];
}
else {
$todate = date('Y') . '-' . date('m') . '-' . date('d');
}
?>
<HTML>
<head>
<title>Stock Manager | EOD Rules | &copy; Robin Wright 2014</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<link href='../../admin.css.php' rel='stylesheet' type='text/css'>
<script type="text/javascript">
function popout(url){
var popup=window.open(url,"Stock Manager Popup","width=700,height=650,scrollbars=1,resizable=1,addressbar=0")
}
</script>

<script>
function updatequery(){
window.location.assign('/ink/audit/?fromdate=' + document.getElementById("fromdate").value + '&todate=' + document.getElementById("todate").value);
}
</script>

<script type="text/javascript" src="../../incs/robins.iframe.wrapper.js"></script>

<script type="text/javascript" src="../../incs/jquery.min.js"></script>

<script type="text/javascript" src="../../incs/jquery.dataTables.nightly.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
  $(function() {
    $( "#fromdate" ).datepicker({ dateFormat: 'yy-mm-dd' });
  });
  </script>

</head>
<body>

<h1 style="margin-left:15px;">EOD Stock Report.</h1>

<div class="mainAudit" onmouseover="Hide('ReportsMenu')" >
<!--
Server message would go here!
-->

<p style="clear:both;">This report will show all stock levels on the given date (from the past) <br/><small>Data collection started on February 4th 2015</small></p>
<p style="clear:both;">Please select date to show:</p>


<form method="POST" action="report.php">
<input class="function" style="
text-decoration: none;
border: 1px #FFF none;
padding-left: 30px;
width: 100px;
height: 30px;
background: url(/ink/icns/calendar2.jpg);
background-repeat: no-repeat; 
background-position: left center;" type="text" id="fromdate" name="fromdate" value="<?PHP echo $todate;?>">
<input type="submit" value="Run Report" />
</form>

<p style="clear:both;">&nbsp;</p>
</div>
</body>
</HTML>