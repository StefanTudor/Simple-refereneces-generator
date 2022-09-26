<?php
$fh = fopen('last_reference.txt','r') or die("Unable to open file!");
$last_ref = intval(fgets($fh)) + 1;
fclose($fh);

echo $last_ref;