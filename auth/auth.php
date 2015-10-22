<?PHP
require "../config/config.php";

?>
<HTML>
<head>
<title>Stock Manager | Admin | &copy; Robin Wright 2014</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<link href='../admin.css.php' rel='stylesheet' type='text/css'>
<link href='../demo_table.css' rel='stylesheet' type='text/css'>
</head>
<body style="margin:0px; padding:0px;">
<center>
<h1>Robin's Ink Stock Manager</h1>
</center>

<?PHP
if(isset($_GET['action'])){
Session_destroy();
echo "You have logged out...";
?>
<script>
window.location.assign('index.php?message=Logout%20Sucessful');
</script>
<?PHP
}

if(isset($_POST['email'])&&isset($_POST['password'])){
$email = strtolower($_POST['email']);

$authquery = mysqli_query($con, "SELECT * 
FROM  `users` 
WHERE `Email` = '$email'
ORDER BY  `UserID` DESC 
LIMIT 0 , 99") or die ('Unable to execute query. '. mysqli_error($con));
$authresult = mysqli_fetch_array($authquery);
if (password_verify($_POST['password'], $authresult['Password'])){
echo "Authentication Sucessful!<br/>Please Wait...";
$_SESSION['CUID'] = $authresult['UserID'];
if ($authresult['Admin'] = True){
$_SESSION['IA'] = True;
}
else {
$_SESSION['IA'] = False;
}
?>
<script>
window.location.assign("../ink.php");
</script>
<?PHP
}
else {
echo "Password incorrect";?>
<script>
window.location.assign("index.php?message=Password%20Incorrect");
</script>
<?PHP
}
mysqli_close($con);
}
else {?>
?>
<script>
window.location.assign('index.php');
</script><?PHP } ?>

<p style="margin:5px;padding:0px;clear:both;text-align:center;">&copy; Robin Wright 2014 </p>
<p style="margin:0px;padding:0px;clear:both;text-align:center;"></p>
</body>
</HTML>