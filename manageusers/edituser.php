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
<title>Edit Existing New</title>
</head>
<body>
<center>
<?PHP
if (isset($_POST['submit'])) {

$email = $_POST['Email'];
$name = $_POST['Name'];
$admin = $_POST['Admin'];
$mail = $_POST['Mail'];
$id = $_GET['userid'];

mysqli_query($con,"UPDATE `inkstock`.`users` SET `Email` = '$email', `Name` = '$name', `Admin` = '$admin', `Mail` = '$mail' WHERE `users`.`UserID` = $id;") or die ('Unable to execute query. '. mysqli_error($con));
echo $_POST['Name'] . " has been updated.<br />";
echo "You can now close this window. ";
}
else {
?>
<h1>Edit <?php echo $_GET['name']; ?></h1>
<?php 
$id = $_GET['userid'];
$result = mysqli_query($con,"SELECT * FROM `users` WHERE `UserID` = $id;");
$row = mysqli_fetch_array($result);
?>
<form method="post" action="">
<table id="example" class="display" cellpadding="5" celspacing="0" style="width:100%;">
<thead>
<tr style='background-color:#666; color:#eee;'><td>Email Address</td><td>Name</td><td>Administrator</td><td>Mailings</td></tr>
</thead>
<tbody>
<?PHP
  echo "<tr><td>" . '<input type="email" style="width:100%;" name="Email" value="' . $row['Email'] . '"/>' . "</td><td>" . '<input type="text" style="width:100%;" name="Name" value="' . $row['Name'] . '"/>' . "</td>"; 
  
  
  if ($row['Admin'] == True){
 $curradmin = "Yes";
 }
 else {
 $curradmin = "No";
 }
 
  if ($row['Mail'] == True){
 $currmail =  "Yes";
 }
 else {
 $currmail = "No";
 }
  
  
  echo "
  <td style='text-align:center;'>
  <select name='Admin'>
  <option value='" . $row['Admin'] . "'>" . $curradmin . " (Current)</option>
  <option value='0'>No</option>
  <option value='1'>Yes</option>
  </select>
  </td>
  ";
  
    echo "
  <td style='text-align:center;'>
  <select name='Mail'>
  <option value='" . $row['Mail'] . "'>" . $currmail . " (Current)</option>
  <option value='0'>No</option>
  <option value='1'>Yes</option>
  </select>
  </td></tr>
  ";
?>
</tbody>
</table>
<input type="submit" name="submit" value="Update" />
</form>
<?PHP } ?>

</center>
</body>
</html>