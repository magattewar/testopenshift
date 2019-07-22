<html>
<head>
	<meta charset="utf-8">
	<title>SMS API - Demo</title>
	<link rel="stylesheet" type="text/css" media="all" href="css/intro.css?v=0.1" />
</head>
<body>


<?php

include 'variables.php';

/**
 * @param $value
 * @return mixed
 */
function escapeJsonString($value) { # list from www.json.org: (\b backspace, \f formfeed)
    $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
}

if (isset($_POST["btnSubmit"])) {

	//SEND SMS
	$url1 = $urlSendSMS;
	$msg = escapeJsonString($_POST["msg"]);
	$data = '{"outboundSMSMessageRequest":{"address":"tel:'.htmlspecialchars($_POST["address"]).'","outboundSMSTextMessage":{"message":"'.$msg.'"},"senderAddress":"tel:+'.$senderAddressURL.'","senderName":"Ostore"}}';
	$data_string = $data;  //json_encode($data);
	$ch = curl_init();	//  Initiate curl
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);	// Disable SSL verification
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                              
	curl_setopt($ch, CURLOPT_SSLVERSION,1);  
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Bearer '.$_GET["token"]));
	curl_setopt($ch, CURLOPT_HEADER, 1);  //TRUE to include the header in the output.
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 300); //timeout in seconds
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	// Will return the response, if false it print the response
	curl_setopt($ch, CURLOPT_URL,$url1);	// Set the url
	$result1=curl_exec($ch);	// Execute
	$parsed_json1 = json_decode($result1, true);
	$httpstatus1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	$curl_errno = curl_errno($ch);
	$curl_error = curl_error($ch);
	if ($curl_errno > 0) {
		echo "<br/>cURL Error ($curl_errno): $curl_error\n<br/><br/>";
	}

	$info = curl_getinfo($ch);
	$header = substr($result1, 0, $info['header_size']);
	$body = substr($result1, $info['header_size']);
	$body = json_decode($body, true);
	
	if ($httpstatus1 == '201') {
		echo '<br/><span STYLE="color: green; font-size: 10pt">';
		echo 'SMS sent successfully to <b>' . $url1 . '</b><br/>';
		echo 'with: <b>' . $data_string . '</b><br/><br/>Returned http '. $httpstatus1 .' is :<br/>';
		print_r ($result1);
		echo '</span><br/>';	
	}
	else {
		echo '<br/><span STYLE="color: red; font-size: 10pt">';
		echo 'Failed to call <b>' . $url1 . '</b><br/>';
		echo 'with: <b>' . $data_string . '</b><br/><br/>Returned http '. $httpstatus1 .' error is :<br/>';
		print_r ($result1);
		echo '</span><br/>';
	}
	curl_close($ch);	// Closing
	echo '<br/>';
}

?>

<form method="POST" id="myform">
	To:&nbsp;<input type="text" name="address" id="address" maxlength="15" value="+" style="text-align: center;" required>
	&nbsp;enter international msisdn such as +221xxxxx for SENEGAL
	<br/><br/>
	Message:&nbsp;<br/>
	<input type="text" name="msg" id="msg" maxlength="160" style="text-align: center; width: 90%; padding: 10px; margin: 0px;" required>
	<br/><br/>
	<input type="Submit" name="btnSubmit" id="btnSubmit" value="Send" >
</form>


</body>
</html>