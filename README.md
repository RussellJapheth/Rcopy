# Rcopy
RCopy uses curl to copy files from a remote server and store them to a local directory.
Rcopy.php is a working example that implements the _downloadFile_ class (**Rcopy-downloadFile-class.php**).
RcopyCLI.php is a comand line version and it includes realtime progress reporting.


#### example using `Rcopy-downloadFile-class.php`.  


```php
<?php
require_once("Rcopy-downloadFile-class.php");

$save = new downloadFile();

$filesize = $save->getSize($url);
$returnData = $save->saveFile($url,$folder);
$save->logDownload($returnData,'logs.php.inc');

print_r($returnData);
print_r($filesize);

```

In the example above **$returnData[]** is an array that contains the data returned by the script

> `$returnData[0]` is set to true or false depending on whether the `curl_exec()` returns `true or false`

> `$returnData[1]` contains the name of the `directory` where the file was stored

> `$returnData[2]` contains the url that was copied

> `$returnData[3]` contains the name of the stored file

> `$returnData[4]` contains the path to the new file 

**$save->getSize($url)** returns the size of the file in bytes

**$save->logDownload($returnData,$logFileName)** creates a php array containing the url and the folder in the file `$logFileName`
