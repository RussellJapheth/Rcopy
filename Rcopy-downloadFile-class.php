<?php
/*
============================================================================================================|||
@author:: Japheth Russell <japheth.russell.i@gmail.com>														|||	
@description:: RCopy uses curl to copy files from a remote server and store them to a local directory.		|||
@version:: 1.0.0																							|||
@todo:: 																									|||
	*compress files remotely before copying to local directory.*											|||
	*rename if there is no name in url eg: saving a webpage like (http://example.com/).						|||
	*logs should be styled *.html* or just plain text *.txt*						                        |||
@notes:: all downloads are logged to a named "Rcopy-Logs-Copied-Files.txt"                              	|||																									
			if the file already exists the new file is renamed.                                         	|||																									
@licence:: THIS SOFTWARE IS PROVIDED AS IS WITHOUT WARRANTY OF ANY KIND INCLUDING BUT NOT LIMITED THE    	|||																									
	WARRANTY (IMPLIED OR OTHERWISE) OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE.				    |||																			   																									
	YOU ARE FREE TO MODIFY AND OR USE THIS SOFTWARE FOR OPEN SOURCE AND COMMERCIAL PROJECTS.        		|||																			   																									
	NO ATTRIBUTION IS REQUIRED BUT A LINK-BACK WOULD BE NICE.										   		|||																			   																									
============================================================================================================|||	
*/
class downloadFile{
	protected $info = array();
		function saveFile($url,$dir){
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
		if(!file_exists(dirname(__FILE__) . '/'.$dir.'/'.$name)){
		//create a new file where its contents will be dumped
		$fp = fopen (dirname(__FILE__) . '/'.$dir.'/'.$name, 'w+');
		
				//Here is the file we are downloading, replace spaces with %20
				$ch = curl_init(str_replace(" ","%20",$urlB));
				
				curl_setopt($ch, CURLOPT_TIMEOUT, 50);
				//disable ssl cert verification to allow copying files from https://
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
				}}else{
					$name = time()."-".$name;
				$fp = fopen (dirname(__FILE__) . '/'.$dir.'/'.$name, 'w+');
		
				//Here is the file we are downloading, replace spaces with %20
				$ch = curl_init(str_replace(" ","%20",$urlB));
				
				curl_setopt($ch, CURLOPT_TIMEOUT, 50);
				//disable ssl cert verification to allow copying files from https://				
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
			echo 'file exists<br />';		
				}
			$returnData[1] = $dir;	
			$returnData[2] = $url;
			$returnData[3] = $name;
echo "The file's name is:: ".$name." <br />";			
			return $returnData;}
}
