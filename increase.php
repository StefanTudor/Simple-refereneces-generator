<?php
$last_refx=null;
$fh = fopen('last_reference.txt','r') or die("Unable to open file!");
$last_refx = intval(fgets($fh)) + 1;
fclose($fh);

$fh = fopen('last_reference.txt','w') or die("Unable to open file!");
fwrite($fh, $last_refx);
fclose($fh);

$log_reg = array('user' => $_COOKIE["user"], 'ref' => $last_refx, 'date'=> date("H:i:s"), 'type'=>0);

$log_file = fopen('log_file.csv', 'a');
fputcsv($log_file, $log_reg);
fclose($log_file);