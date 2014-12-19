<?php


// pushOneId('');
	
 function pushOneId ($deviceId = '', $title, $url){
	
// 	JFactory::getApplication()->enqueueMessage('push()2');
// Put your device token here (without spaces):

 	$tokens = array('b67af00171a9c3097f9f52eb5d82eb067424ee747560a00f553b5bb940e4335b','1b82c6f44dae3066451b509bd4e8ac06c525feec6731a118143dd3967747f325','97782edd1bdf5ace2c6810970c4b83accbd0ea854d95867c0e6e4eae7635cdfb');
 	$deviceToken = 'b67af00171a9c3097f9f52eb5d82eb067424ee747560a00f553b5bb940e4335b';
//$deviceToken = '1b82c6f44dae3066451b509bd4e8ac06c525feec6731a118143dd3967747f325';
// $deviceToken = '97782edd1bdf5ace2c6810970c4b83accbd0ea854d95867c0e6e4eae7635cdfb';
// Put your private key's passphrase here:
$passphrase = '123456';

// Put your alert message here:
$message = 'Breaking news: ';

// $title = 'Foreign scammers target ACT in fraud case';
// $url = 'http://www.rebonline.com.au/breaking-news/7932-foreign-scammers-target-act-in-fraud-case';
////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'C:\steven\demo\HybridWebviewDemo\php_apn\push\pushcert_old.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
// $fp = stream_socket_client(
	// 'ssl://gateway.sandbox.push.apple.com:2195', $err,
	// $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
$fp = stream_socket_client(
	'ssl://gateway.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS <br/> <br/>' . PHP_EOL;

// Create the payload body
$body['aps'] = array(
	'alert' => $message.$title ,
	'sound' => 'default',
	'title' => $title,
	'url'   => $url
	);

// Encode the payload as JSON
$payload = json_encode($body);

$count = 0;
foreach ($tokens as $token){

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $token) . pack('n', strlen($payload)) . $payload;


$count = $count +1;
// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
	echo 'No.' . $count .' Message not delivered  <br/>' . PHP_EOL;
else
	echo 'No.' . $count . ' Message successfully delivered  <br/>' . PHP_EOL;

}

// Close the connection to the server
fclose($fp);

}

