<?php

use Aws\S3\S3Client;

include dirname(__FILE__).'/../private/config.inc.php';

$size = (int)$_REQUEST['size'];
$file = CDN_ORIGIN.$_REQUEST['path'];
$next = CDN_CACHE.'sq/'.$size.'/'.$_REQUEST['path'];

if (strlen($_REQUEST['path']) < 41) { header("HTTP/1.0 404 Not Found"); exit(); }

if (false === @file_get_contents($next,0,null,0,1)) {

	if (false === @file_get_contents($file,0,null,0,1)) {
	  echo 'error upload';
	} else {

		try {
			
			$img_info = pathinfo($_REQUEST['path']);
			$tmp_name = dirname(__FILE__).'/../temp_upload/'.uniqid().'.'.strtolower($img_info['extension']);
			
			$image = new Gmagick($file);
			$image->cropthumbnailimage($size,$size);		

			$image->write($tmp_name);
			$content = file_get_contents($tmp_name);
			unlink($tmp_name);			
			
			if (isset($_REQUEST['debug'])) {
				header("Content-type: ".$ext_myme[strtolower($img_info['extension'])]);
				echo $content;
				exit();
			}
			
			// Instantiate the S3 client with your AWS credentials and desired AWS region
			$client = S3Client::factory(array(
			  'key'    => AWS_KEY,
			  'secret' => AWS_SCRT,
			));
			
			// set the file key
			$file_key = 'sq/'.$size.'/'.$_REQUEST['path'];
			
			// Upload file in bucket v2
			$acl = 'public-read';
			$client->putObject(
				array(
					'ACL' => $acl,
					'Bucket' => AWS_BUCKET,
					'Body' => $content,
					'ContentType' => $ext_myme[strtolower($img_info['extension'])],
					'Key' => $file_key
				)
			);

			header("Location: $next",TRUE,301);
			exit();

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	
	}

} else {
	
	header("Location: $next",TRUE,301);
	exit();
	
}