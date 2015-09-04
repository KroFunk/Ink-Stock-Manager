<?
require '../../config/config.php';
?>
<HTML>
<head>
<title>Stock Manager | Admin | &copy; Robin Wright 2014</title>
<link rel="stylesheet" href="jquery/jquery.mobile-1.4.5.min.css">
<script src="jquery/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
$(document).bind("mobileinit", function()
{
  $.extend(  $.mobile , {
      ajaxFormsEnabled: false
  });
});
</script> 
<script src="jquery/jquery.mobile-1.4.5.min.js"></script>

<style>
.ui-page { 
background:#2b2e31;
}
</style>

</head>
<body>
<h1 style="text-align:center;color:white;">Robin's Ink Stock Manager API v1</h1>
<div style="margin:20px; padding-left:8px; padding-right:8px; width: 90%; margin:0 auto; background: #aaa; border:1px solid #666; border-radius:5px;">

<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Authentication</h2>
<p>PATH: <? echo $Directory; ?>api/v1/authentication/</p>
<p>Authentication API used to create or destroy a session.</p>
<p>Authentication is required to access all other operations.</p>
<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Login</h2>
<form action="authentication/" data-ajax="false" method="POST">
<input type="hidden" name="action" value="login" />
<input  id="email" type="email" value="Email Address"  onclick="if(this.value=='Email Address'){this.value='';this.style.color='black';}" onblur="if(this.value==''){this.value='Email Address';this.style.color='grey';}" name="email" style="color:grey;">
<input  id="password" type="text" value="Password" onClick="if(this.value=='Password'){this.value='';}" onFocus="if(this.value=='Password'){this.value='';} this.type='password';this.style.color='black';" onblur="if(this.value==''){this.value='Password';this.type='text';this.style.color='grey';}" name="password" style="color:grey;">
<input  type="submit" value="Login"  />
</form>
</div>
<div data-role="collapsible">
<h2>Logout</h2>
<form action="authentication/" data-ajax="false" method="POST">
<input type="hidden" name="action" value="logout" />
<input  type="submit" value="Logout"  />
</form>
</div>
</div>

<div data-role="collapsible">
<h2>List</h2>
<p>PATH: <? echo $Directory; ?>api/v1/list/list.php</p>
<p>List API used to fetch data from the database.</p>
<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Stock</h2>
<form action="list/list.php" data-ajax="false" method="POST">
<input type="hidden" name="action" value="liststock" />
Where IID EQUALS: (optional)
<input  type="number" name="IID" >
<input  type="submit" value="List Stock"  />
</form>
</div>
<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Printers</h2>
<form action="list/list.php" data-ajax="false" method="POST">
<input type="hidden" name="action" value="listprinters" />
Where PID EQUALS: (optional)
<input  type="number" name="PID" >
<input  type="submit" value="List Printers"  />
</form>
</div>
<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Users (Requires admin permissions)</h2>
<form action="list/list.php" data-ajax="false" method="POST">
<input type="hidden" name="action" value="listusers" />
Where UserID EQUALS: (optional)
<input  type="number" name="UserID" >
Show:
<table>
<tr><td>Is Admin</td><td> <input type="checkbox" name="admin" value="true" checked /></td></tr>
<tr><td>Not Admin</td><td> <input type="checkbox" name="notadmin" value="true" checked /></td></tr>
<tr><td>Gets Mail</td><td> <input type="checkbox" name="mail" value="true" checked /></td></tr>
<tr><td>No Mail</td><td> <input type="checkbox" name="nomail" value="true" checked /></td></tr>
</table>

<input  type="submit" value="List Users"  />
</form>
</div>
<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Audit</h2>
<form action="list/list.php" data-ajax="false" method="POST">
<input type="hidden" name="action" value="listaudit" />
From:
<input  type="date" name="fromdate" required>
To:
<input  type="date" name="todate" required>
Show:
<table>
<tr><td>Stock Added</td><td> <input type="checkbox" name="stockadded" value="true" checked /></td></tr>
<tr><td>Stock Removed</td><td> <input type="checkbox" name="stockremoved" value="true" checked /></td></tr>
<tr><td>Stock Checks</td><td> <input type="checkbox" name="stockcheck" value="true" checked /></td></tr>
<tr><td>Data Created</td><td> <input type="checkbox" name="stockcreated" value="true" checked /></td></tr>
<tr><td>Data Deleted</td><td> <input type="checkbox" name="stockdeleted" value="true" checked /></td></tr>
</table>

<input  type="submit" value="List Audit"  />
</form>
</div>
</div>

<div data-role="collapsible">
<h2>Update</h2>
<p>PATH: <? echo $Directory; ?>api/v1/update/update.php</p>
<p>Update API used to modify existing stock, printer and location records in the database.
<strong><br/>This operation is recorded in the Audit</strong></p>
<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Stock</h2>
<form action="update/update.php" data-ajax="false" method="POST">
<input type="hidden" name="action" value="updatestock" />
PID:
<input  type="text" name="PID" ><br/>
InkName:
<input  type="text" name="inkname" ><br/>
Price:
<input  type="text" name="price" ><br/>
Stock:
<input  type="text" name="stock" ><br/>
StockWarning:
<input  type="text" name="stockwarning" ><br/>
StockDefault:
<input  type="text" name="stockdefault" ><br/>
OrderURL:
<input  type="text" name="orderurl" ><br/>
OnOrder:
<input  type="text" name="onorder" ><br/>
UPC:
<input  type="text" name="UPC" ><br/>

Where IID EQUALS:
<input  type="text" name="IID" ><br/>

<input  type="submit" value="Update Stock"  />
</form>
</div>
<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Printers</h2>
<form action="update/update.php" data-ajax="false" method="POST">
<input type="hidden" name="action" value="updateprinter" />
Printer Make:
<input  type="text" name="printermake" >
Printer Model:
<input  type="text" name="printermodel" >
Support Link:
<input  type="text" name="supportlink" >
Colour:
<input  type="text" name="colour" >
Media:
<input  type="text" name="media" >
Type:
<input  type="text" name="type" >

Where PID EQUALS:
<input  type="text" name="PID" >
<input  type="submit" value="Update Printer"  />
</form>
</div>


<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Users</h2>
<form action="update/update.php" data-ajax="false" method="POST">
<input type="hidden" name="action" value="updateuser" />
Name:
<input  type="text" name="name" ><br/>
Email:
<input  type="email" name="email" ><br/>
Admin:
<input  type="text" name="admin" ><br/>
Mail:
<input  type="text" name="mail" ><br/>
Password:
<input  type="password" name="password" ><br/>

Where UserID EQUALS:
<input  type="text" name="UserID" ><br/>

<input  type="submit" value="Update User"  />
</form>
</div>


<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Locations</h2>
<form action="update/update.php" data-ajax="false" method="POST">
<input type="hidden" name="action" value="updatelocation" />
Location Name:
<input  type="text" name="room" >
PID:
<input  type="text" name="PID" >


Where DID EQUALS:
<input  type="text" name="DID" >
<input  type="submit" value="Update Location"  />
</form>
</div>

</div>

<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Create (Requires admin permissions)</h2>

<p>PATH: <? echo $Directory; ?>api/v1/list/create.php</p>
<p>Create API used to make new stock, printer and location records in the database.
<strong><br/>This operation is recorded in the Audit</strong></p>

<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Stock</h2>
<form action="create/create.php" data-ajax="false" method="POST">
<input type="hidden" name="action" value="createstock" />
PID:
<input  type="text" name="PID" ><br/>
InkName:
<input  type="text" name="inkname" ><br/>
Price:
<input  type="text" name="price" ><br/>
Stock:
<input  type="text" name="stock" ><br/>
StockWarning:
<input  type="text" name="stockwarning" ><br/>
StockDefault:
<input  type="text" name="stockdefault" ><br/>
OrderURL:
<input  type="text" name="orderurl" ><br/>
OnOrder:
<input  type="text" name="onorder" ><br/>
UPC:
<input  type="text" name="UPC" ><br/>


<input  type="submit" value="Create Stock"  />
</form>
</div>

<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Printers</h2>
<form action="create/create.php" data-ajax="false" method="POST">
<input type="hidden" name="action" value="createprinter" />
Printer Make:
<input  type="text" name="printermake" >
Printer Model:
<input  type="text" name="printermodel" >
Support Link:
<input  type="text" name="supportlink" >
Colour:
<input  type="number" name="colour" >
Media:
<input  type="text" name="media" >
Type:
<input  type="text" name="type" >

<input  type="submit" value="Create Printer"  />
</form>
</div>

<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Users</h2>
<form action="create/create.php" data-ajax="false" method="POST">
<input type="hidden" name="action" value="createuser" />
Name:
<input  type="text" name="name" ><br/>
Email:
<input  type="email" name="email" ><br/>
Admin:
<input  type="text" name="admin" ><br/>
Mail:
<input  type="text" name="mail" ><br/>
Password:
<input  type="password" name="password" ><br/>

<input  type="submit" value="Create User"  />
</form>
</div>

<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Locations</h2>
<form action="create/create.php" data-ajax="false" method="POST">
<input type="hidden" name="action" value="createlocation" />
Location Name:
<input  type="text" name="room" >
PID:
<input  type="text" name="PID" >

<input  type="submit" value="Create Location"  />
</form>
</div>


</div>

<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Delete (Requires admin permissions)</h2>

<p>PATH: <? echo $Directory; ?>api/v1/list/delete.php</p>
<p>Update API used to delete existing stock, printer and location records in the database.
<strong><br/>This operation is recorded in the Audit</strong></p>

<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Stock</h2>
<form action="delete/delete.php" data-ajax="false" method="POST">
<input type="hidden" name="action" value="deletestock" />

Where IID EQUALS:
<input  type="text" name="IID" ><br/>

<input  type="submit" value="Delete Stock"  />
</form>
</div>
<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Printers</h2>
<form action="delete/delete.php" data-ajax="false" method="POST">
<input type="hidden" name="action" value="deleteprinter" />

Where PID EQUALS:
<input  type="text" name="PID" >
<input  type="submit" value="Delete Printer"  />
</form>
</div>

<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Users</h2>
<form action="delete/delete.php" data-ajax="false" method="POST">
<input type="hidden" name="action" value="deleteuser" />

Where UserID EQUALS:
<input  type="text" name="UserID" >
<input  type="submit" value="Delete User"  />
</form>
</div>

<div data-role="collapsible" data-theme="a" data-content-theme="a">
<h2>Locations</h2>
<form action="delete/delete.php" data-ajax="false" method="POST">
<input type="hidden" name="action" value="deletelocation" />

Where DID EQUALS:
<input  type="text" name="DID" >
<input  type="submit" value="Delete Location"  />
</form>
</div>


</div>

</div>
<br/>
</body>
</HTML>