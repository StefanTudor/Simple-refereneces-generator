<?php

if (!empty($_POST["updated_ref"])) {
    $fh = fopen('last_reference.txt','w') or die("Unable to open file!");
	$updatedRef = intval($_POST["updated_ref"]) -1;
	fwrite($fh, $updatedRef);
	fclose($fh);
	
	$log_reg = array('user' => $_COOKIE["user"], 'ref' => $updatedRef+1, 'date'=> date("H:i:s"), 'type'=>1);

	$log_file = fopen('log_file.csv', 'a');
	fputcsv($log_file, $log_reg);
	fclose($log_file);

}