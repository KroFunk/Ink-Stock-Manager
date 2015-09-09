<div class="menuLocked" id="menu">
<div id='width'>
<div style='float:left;'>
<img src="<?php echo $Location ?>/icns/logo.png" height="22px" />
Ink Stock Manager 
<a href='<?php echo $Location ?>/stock/' target='_parent'>Stock</a> 
<a href='<?php echo $Location ?>/printers/'>Printers</a> 
<a href='<?php echo $Location ?>/audit'>Audit</a> 
<a href='<?php echo $Location ?>/stockcheck/' target='_new'>Stock Check</a> 
<a href="javascript:ShowHide('ReportsMenu');">Reports</a> 
</div>
<a href='<?php echo $Location ?>/manageusers/' target='_self'>Manage users</a> 
<a href='<?php echo $Location ?>/auth/auth.php?action=logout'>logout</a>
<div id="ReportsMenu" class="reports"  style="display:none;">
<a href="javascript:popup('<?php echo $Location ?>/reports/ink_usage/rules.php')">Ink Usage</a> 
<a href="javascript:popup('<?php echo $Location ?>/reports/printer_usage/rules.php')">Printer Usage</a> 
<a href="javascript:popup('<?php echo $Location ?>/reports/department_usage/rules.php')">Department Usage</a>
<a href="javascript:popup('<?php echo $Location ?>/stockwarning')" >Stock Warnings</a>
<a href="javascript:popup('<?php echo $Location ?>/reports/eod/rules.php')" >EOD Stock Report</a>
</div>
</div>
</div>
