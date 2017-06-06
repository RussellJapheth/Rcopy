<?php
require_once("Rcopy-downloadFile-class.php");

$save = new downloadFile();

$filesize = $save->getSize($url);
$returnData = $save->saveFile($url,$folder);
$save->logDownload($returnData,'logs.php.inc');

print_r($returnData);
print_r($filesize);
