<?PHP
session_start();
require "../config/config.php";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

<title>Delete Existing User | Stock Manager | &copy; Robin Wright</title>
<link href='http://fonts.googleapis.com/css?family=Roboto:300,100' rel='stylesheet' type='text/css'>
<link href='adminwhite.css' rel='stylesheet' type='text/css'>
<script type="text/javascript">
function popout(url){
var popup=window.open(url,"","width=700,height=480,scrollbars=yes,resizable=yes,addressbar=no")
}
</script>
</head>
<body>
<center>
<?PHP


if (isset($_POST['submit'])){

if (isset($_GET['Name']) && isset($_GET['UserID'])) {


$index = $_GET['UserID'];


mysqli_query($con,"DELETE FROM `users` WHERE `users`.`UserID` = $index;");



echo $_GET['Name'] . " has been deleted! <br/>...";
echo "You may now close this window.";
}
} else{?>

<h1>Delete <?PHP echo $_GET['Name']; ?>?</h1> 

Are you sure you want to delete <?php echo $_GET['Name']; ?>? This cannot be undone.
<form action="" method="POST">
<input type="submit" name="submit" value="Yes" />
</form>


<?php
}
?>

</center>
</body>
</html>