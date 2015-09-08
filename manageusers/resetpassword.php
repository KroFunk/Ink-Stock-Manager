<?PHP

require "../config/config.php";
if(isset($_GET['index'])){$index = $_GET['index'];}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link href='../adminwhite.css' rel='stylesheet' type='text/css'>
<title>Reset User Password</title>
</head>
<body>
<center>
<?PHP
if (isset($_POST['submit'])) {

$userid = $_POST['userid'];
$name = $_POST['name'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

mysqli_query($con,"UPDATE `inkstock`.`users` SET `Password` = '$password' WHERE `users`.`UserID` = $userid;");
echo "The password for " . $_POST['name'] . " has been reset.<br />";
echo "You can now close this window. ";
}
else {
?>
<h1>Reset password for <?php $_GET['name']; ?></h1>
<form method="post" action="">
<table id="example" class="display" cellpadding="5" celspacing="0" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td>New Password</td></tr>
</thead>
<tbody>
<?PHP
  echo "<tr><td>" . '<input type="password" style="width:100%;" name="password" value=""/>' . "</td></tr>";
?>
</tbody>
</table>
<input type="hidden" name="name" value="<?php echo $_GET['name']; ?>" />
<input type="hidden" name="userid" value="<?php echo $_GET['userid']; ?>" />
<input type="submit" name="submit" value="Reset" />
</form>
<?PHP } ?>

</center>
</body>
</html>