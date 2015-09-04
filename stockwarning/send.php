<?php
//fetch and store the report as a string in memory
ob_start();
include('index.php');
$output = ob_get_contents();
ob_end_clean();

//define email headers
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//$headers .= 'To: Example <example@example.com>' . "\r\n";
$headers .= 'From: No Reply <noreply@example.com>' . "\r\n";

// multiple recipients
$to  = 'example@example.com';

// subject
$subject = "Stock to Order (Robin's Ink Stock Manager)";

if(mail($to, $subject, $output, $headers)){
      echo('ok');
    }
else{
      echo('not ok');
    }
?>