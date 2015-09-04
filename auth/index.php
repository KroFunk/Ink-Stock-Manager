<?PHP
session_start();
?>
<HTML>
<head>
<title>Stock Manager | Admin | &copy; Robin Wright 2014</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<link href='../admin.css' rel='stylesheet' type='text/css'>
<link href='../demo_table.css' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="../incs/jquery.min.js"></script>
<script>
window.onload = function() {
if (document.getElementById('email').value=='Email Address'){
document.getElementById('email').style.color='grey';
}
document.getElementById('password').value='Password';
document.getElementById('password').style.color='grey';
}
</script>


</head>
<body style="margin:0px; padding:0px;">
<img src="../incs/blur.jpg" class="bg" />



<div style="position:absolute; top:50%; margin-top:-135px; width:100%; background:#fff; padding:0px; padding-top:20px;">
<center>
<h1>Ink Stock Manager</h1>
<form action="auth.php" method="POST">
<input class="textbox" id="email" type="email" value="Email Address"  onclick="if(this.value=='Email Address'){this.value='';this.style.color='black';}" onblur="if(this.value==''){this.value='Email Address';this.style.color='grey';}" name="email" style="width:250px; font-size:14px; padding:5px;margin-bottom:2px;"><br/>
<input class="textbox" id="password" type="text" value="Password" onClick="" onFocus="this.type='password';this.style.color='black'; if(this.value=='Password'){this.value='';}" onblur="if(this.value==''){this.value='Password';this.type='text';this.style.color='grey';}" name="password" style="width:250px; font-size:14px; padding:5px;margin-bottom:2px;color:grey;"><br/>
<input class="textbox" type="submit" value="Login" style="width:250px; font-size:14px; background-color:#297ACC; border-color:#103152; color:#fff; padding:5px;margin-bottom:25px;" />
</form>
</center>
</div>

<p style="margin:5px;padding:0px; color:#000; font-size:10px; width:99%; clear:both;text-align:center; position:absolute; bottom:0px;">&copy; <a href="https://chalkcreation.co.uk/" target="_new" style="color:#000; text-decoration:none;">Robin Wright 2014</a></p>
<p style="margin:0px;padding:0px;clear:both;text-align:center;"></p>
<?php
if(isset($_GET['message'])){
echo "<div class='servermessage'>" . $_GET['message'] . "</div>";
}
?>
</body>
</HTML>