<?PHP
session_start();
require "../config/config.php";
if(isset($_GET['index'])){$index = $_GET['index'];}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link href='../adminwhite.css' rel='stylesheet' type='text/css'>
<title>Add New User</title>
</head>
<body>
<center>
<?PHP
if (isset($_POST['submit'])) {

$email = $_POST['Email'];
$name = $_POST['Name'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$admin = $_POST['Admin'];
$mail = $_POST['Mail'];

mysqli_query($con,"INSERT INTO `inkstock`.`users` (`UserID`, `Email`, `Name`, `Password`, `Admin`, `Mail`) VALUES (NULL, '$email', '$name', '$password', '$admin', '$mail')") or die ('Unable to execute query. '. mysqli_error($con));
echo $_POST['Name'] . " has been created.<br />";
echo "You can now close this window. ";
}
else {
?>
<h1>Add a new User</h1>
<form method="post" action="">
<table id="example" class="display" cellpadding="5" celspacing="0" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td>Email Address</td><td>Name</td><td>Administrator</td><td>Mailings</td><td>Password</td></tr>
</thead>
<tbody>
<?PHP
  echo "<tr><td>" . '<input type="email" style="width:100%;" name="Email" value=""/>' . "</td><td>" . '<input type="text" style="width:100%;" name="Name" value=""/>' . "</td>"; 
  
  echo "
  <td style='text-align:center;'>
  <select name='Admin'>
  <option value='0'>No</option>
  <option value='1'>Yes</option>
  </select>
  </td>
  ";
  
    echo "
  <td style='text-align:center;'>
  <select name='Mail'>
  <option value='0'>No</option>
  <option value='1'>Yes</option>
  </select>
  </td>
  ";
  
  echo '<td><input type="password" style="width:100%;" name="password" value=""/>' . "</td></tr>";
?>
</tbody>
</table>
<input type="submit" name="submit" value="Create" />
</form>
<?PHP } ?>

</center>
</body>
</html>