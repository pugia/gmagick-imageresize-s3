<?php
	
// amazon S3 credentials
define('AWS_KEY', 'your_key');
define('AWS_SCRT', 'your_secret');
define('AWS_BUCKET', 'cache_bucket');

// CDN of the bucket where the original file is uploaded
define('CDN_ORIGIN', 	'http://abcdefghijklmn.cloudfront.net');

// CDN of the cache bucket
define('CDN_CACHE',		'http://opqrstuvwxyz01.cloudfront.net');
