<?php
ob_start();

echo "Starting Download ... \r\n";

ob_flush();
flush();
if (isset($argv[2]) && !empty($argv[2]))
{
    $file = $argv[2];
}
else
{
    $file = 'file';
}
$targetFile = fopen($file, 'w+');
file_put_contents('log.txt', '');
$GLOBALS['logFile'] = fopen('log.txt', 'a+');

$ch = curl_init();
if (isset($argv[1]) && !empty($argv[1]))
{
    curl_setopt($ch, CURLOPT_URL, $argv[1]);
}
else
{
    echo "ERROR: invalid url \r\nterminatting.....\r\n";
    ob_flush();
    flush();
    exit();
}

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, 'progress');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
if (file_exists($file))
{
    $from = filesize($file);
    curl_setopt($ch, CURLOPT_RANGE, $from . "-");
}
curl_setopt($ch, CURLOPT_NOPROGRESS, false); // needed to make progress function work
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FILE, $targetFile);
$curlRes = curl_exec($ch);
fclose($targetFile);
file_put_contents('dump.json', json_encode(curl_getinfo($ch)));
file_put_contents('curl.json', json_encode($curlRes));
curl_close($ch);

function progress($resource, $download_size, $downloaded, $upload_size, $uploaded)
{
    if ($download_size > 0)
    {
        $ec = $downloaded / $download_size * 100;
    }
    else
    {
        $ec = 0;
    }
    
    $ec = round($ec, 2);
    $ec = $ec . " percent has been downloaded \r\n";
    echo $ec;
    fwrite($GLOBALS['logFile'], $ec);
    ob_flush();
    flush();
    //sleep(1); // just to see effect
}
fclose($GLOBALS['logFile']);
if ($curlRes)
{
    echo "Download Completed  (^_^)\r\n";
}
else
{
    echo "Downloading Failed  \r\n";
}
ob_flush();
flush();

