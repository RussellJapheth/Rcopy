# Rcopy
RCopy uses curl to copy files from a remote server and store them to a local directory.
Rcopy.php is a working example that implements the _downloadFile_ class (**Rcopy-downloadFile-class.php**).
e.g.  

`$save = new downloadFile();
$returnData = $save->saveFile($_REQUEST['url'],$_REQUEST['folder']);`
