<?php 
//
//  ,ad8888ba,  88                     88 88         
// d8"'    `"8b 88                     88 88         
//d8'           88                     88 88         
//88            88,dPPYba,  ,adPPYYba, 88 88   ,d8   
//88            88P'    "8a ""     `Y8 88 88 ,a8"    
//Y8,           88       88 ,adPPPPP88 88 8888[      
// Y8a.    .a8P 88       88 88,    ,88 88 88`"Yba,   
//  `"Y8888Y"'  88       88 `"8bbdP"Y8 88 88   `Y8a 
//
//                                                                                   
//  ,ad8888ba,                                           88                          
// d8"'    `"8b                                    ,d    ""                          
//d8'                                              88                                
//88            8b,dPPYba,  ,adPPYba, ,adPPYYba, MM88MMM 88  ,adPPYba,  8b,dPPYba,   
//88            88P'   "Y8 a8P_____88 ""     `Y8   88    88 a8"     "8a 88P'   `"8a  
//Y8,           88         8PP""""""" ,adPPPPP88   88    88 8b       d8 88       88  
// Y8a.    .a8P 88         "8b,   ,aa 88,    ,88   88,   88 "8a,   ,a8" 88       88  
//  `"Y8888Y"'  88          `"Ybbd8"' `"8bbdP"Y8   "Y888 88  `"YbbdP"'  88       88 
//

@$message = $_GET['message'];
$isedit = true;
require "resources/config.php";
?> 
<html>

<head>

<title>MessageBoard</title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<style type="text/css">
body 
{
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
    cursor: none;
    overflow: hidden;
}
body,td,th 
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 56px;
}
.header 
{
	display:block;
	height:80px;
	width:100%;
	text-align:left;
	background:#FFF;
	position:fixed;
	top:0px;
	padding-left:10px;
	z-index:999;
}
</style>

</head>

<body>
 
<div class="header"><img src="resources/site_images/logo.png" height="80" alt="Messages"></div>

<img src="resources/site_images/top.png" style="position:fixed; top:80px; width:100%; height:50px;" />

<?php 
if ($message):
//nothing, business as usual
else:
$message = "FTL15920011048449";
endif;
?>

<div id="content" style="padding:10px; padding-top:70px; z-index:-1;">
<?php
if ($isconfigured = false):
echo "<h1>The config file has not been configured, please edit config.php</h1>";
endif;
include "resources/messages/" . $message . ".txt"; 
?>
</div>

<!--
This feature was removed, may be reincluded as a customisation option.
<script type="text/javascript">

var elem = (document.compatMode === "CSS1Compat") ? 
document.documentElement :
document.body;

var height = elem.clientHeight;
var width = elem.clientWidth;
document.writeln("<div style='height:" + height + "px;'>&nbsp;</div>")

</script>
--> 

<img src="resources/site_images/bottom.png" style="position:fixed; bottom:0px; width:100%; height:50px;" />

<script type="text/javascript">
<!--
var h = (document.getElementById('content').clientHeight - 200);
var d = window.innerHeight;

if (d<h)
	{
		setTimeout(function () 
		{
			window.location = "javascript:var isScrolling; var scrolldelay; function pageScroll() { window.scrollBy(0,1); scrolldelay = setTimeout('pageScroll()',60); isScrolling = true; } if(isScrolling != true) { pageScroll(); } else {  isScrolling = false; clearTimeout(scrolldelay); }";
		},<?php echo $beforescroll ?>);
	}
else
	{
		setTimeout(function () 
		{
			window.location =  "clock.php?message=<?php echo $message ?>";
		},<?php echo $noscroll ?>);
	}
//-->
</script>

<script type="text/javascript">
<!--
window.onscroll = function(ev) 
	{
		if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight)
		{
		
			setTimeout(function () 
			{
				window.location = "clock.php?message=<?php echo $message ?>";
			},<?php echo $afterscroll ?>);
			
		}
	}
//-->	
</script>

</body>

</html>
