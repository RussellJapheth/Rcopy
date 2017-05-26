# Rcopy
RCopy uses curl to copy files from a remote server and store them to a local directory.
Rcopy.php is a working example that implements the _downloadFile_ class (**Rcopy-downloadFile-class.php**).


## example using ## ### `Rcopy-downloadFile-class.php` ###.  


```php
<?php

require_once("Rcopy-downloadFile-class.php");

$save = new downloadFile();

$returnData = $save->saveFile($_REQUEST['url'],$_REQUEST['folder']);

```

In the example above **$returnData[]** is an array that contains the data returned by the script

> `$returnData[0]` returns true or false depending on whether the `curl_exec()` returns `true or false`

> `$returnData[1]` returns the name of the `directory` where the file was stored

> `$returnData[2]` returns the url that was copied

> `$returnData[3]` returns the name of the stored file
