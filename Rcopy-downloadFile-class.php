/*
============================================================================================================
@author:: Japheth Russell <japheth.russell.i@gmail.com>															
@description:: RCopy uses curl to copy files from a remote server and store them to a local directory.		
@version:: 1.0.0																							                                      																										
@licence:: THIS SOFTWARE IS PROVIDED AS IS WITHOUT WARRANTY OF ANY KIND INCLUDING BUT NOT LIMITED THE    																										
	WARRANTY (IMPLIED OR OTHERWISE) OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE.				    																			   																									
	YOU ARE FREE TO MODIFY AND OR USE THIS SOFTWARE FOR OPEN SOURCE AND COMMERCIAL PROJECTS.        																					   																									
	NO ATTRIBUTION IS REQUIRED.										   																					   																									
============================================================================================================	
*/
class downloadFile{
	public function getSize($url) {
  // Assume failure.
  $result = -1;

  $curl = curl_init( $url );

  // Issue a HEAD request and follow any redirects.
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt( $curl, CURLOPT_NOBODY, true );
  curl_setopt( $curl, CURLOPT_HEADER, true );
  curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
  curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
  curl_setopt( $curl, CURLOPT_USERAGENT,  $_SERVER['HTTP_USER_AGENT']);

  $data = curl_exec( $curl );
  curl_close( $curl );

  if( $data ) {
    $content_length = "unknown";
    $status = "unknown";

    if( preg_match( "/^HTTP\/1\.[01] (\d\d\d)/", $data, $matches ) ) {
      $status = (int)$matches[1];
    }

    if( preg_match( "/Content-Length: (\d+)/", $data, $matches ) ) {
      $content_length = (int)$matches[1];
    }

    if( $status == 200 || ($status > 300 && $status <= 308) ) {
      $result = $content_length;
    }
  }

  return $result;
}
		public function saveFile($url,$dir){
			$urlB = $url;	
		//remove the query string and get the file name
		if ($url = parse_url($url)) {
			$cleanUrl = $url['scheme'].$url['host'].$url['path'];
		}
		//get the pathinfo() of the url
		$cleanUrl = pathinfo($cleanUrl);
		//get the file name
		$name = $cleanUrl['basename'];

		//check if the directory exists and create a new directory if it does not
		if(!file_exists($dir)){
			mkdir($dir);
		}
		//check if the file exists and append a timestamp to its name if it does
		if(file_exists(dirname(__FILE__) . '/'.$dir.'/'.$name)){$name = time()."-".$name;}
		
		//create a new file where its contents will be dumped
		$fp = fopen (dirname(__FILE__) . '/'.$dir.'/'.$name, 'w+');
		
				//Here is the file we are downloading, replace spaces with %20
				$ch = curl_init(str_replace(" ","%20",$urlB));
				
				curl_setopt($ch, CURLOPT_TIMEOUT, 50);
				//disable ssl cert verification to allow copying files from HTTPS NB: you can always fix your php 'curl.cainfo' setting so yo dont have to disable this 
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				// write curl response to file
				curl_setopt($ch, CURLOPT_FILE, $fp); 
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			
				// get curl response
				$exec = curl_exec($ch); 
				
				curl_close($ch);
				fclose($fp);
			if($exec == true){
				$returnData[0] = true;
			}else{
					$returnData[0] =false;
				}
			$returnData[1] = $dir;	
			$returnData[2] = $url;
			$returnData[3] = $name;
			$returnData[4] = $dir.'/'.$name;
			return $returnData;
			}
		public function logDownload($returnData,$logFile){
$dir = $returnData[1];
if(isset($returnData[2]['query'])){
	$url = $returnData[2]['scheme'].'://'.$returnData[2]['host'].$returnData[2]['path'].'?'.$returnData[2]['query'];
		}else{
			$url = $returnData[2]['scheme'].'://'.$returnData[2]['host'].$returnData[2]['path'];
	}
if(!file_exists($logFile)){
$myfile = fopen($logFile, "w+") or die("Unable to open file!");	
$txt =<<<EOD
<?php
\$i = 0; 
EOD;
fwrite($myfile, $txt);
fclose($myfile);
}
$myfile = fopen($logFile, "a+") or die("Unable to open file!");
$txt =<<<EOD
\$url[\$i] === $url;
\$dir[\$i] === $dir;
EOD;
fwrite($myfile, "\r\n".$txt);
$ret = fclose($myfile); 
return $ret;		
		}	
}
