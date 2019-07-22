<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>OrangePartner - Token Generator</title>
	<link rel="stylesheet" type="text/css" media="all" href="css/intro.css?v=0.1" />
	<script>
		function validateForm() {
			var x = myform.consumerkey.value;
			if (x == null || x == "") {
				alert("Please, Generate a Consumer_key !");
				return false;
			}
			else {
				return true;
			}
		}
	</script>
</head>

<?php

if (isset($_POST["btnSubmit"])) {

	$url1 = "https://api.orange.com/oauth/v2/token";
	$data_string = 'grant_type=client_credentials';  //json_encode($data);
	// SET PROXY (FOR KERMIT)
	$proxy_host=getenv("KERMIT_HTTP_PROXY_INTERNET_HOST");
	$proxy_port=getenv("KERMIT_HTTP_PROXY_INTERNET_PORT");
	$ch = curl_init();	//  Initiate curl
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);	// Disable SSL verification
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                              
	curl_setopt($ch, CURLOPT_SSLVERSION,1);  
	curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_port);
	curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
	curl_setopt($ch, CURLOPT_PROXY, $proxy_host);
	curl_setopt($ch, CURLOPT_PROXYUSERPWD, "");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded','Authorization: Basic '.$_POST["consumerkey"]));
	curl_setopt($ch, CURLOPT_HEADER, 0);  //TRUE to include the header in the output.
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
	
	//trim($str, '"');
	if ($httpstatus1 == '200') {
		echo '<pre>The generated Token is ';
		$token = $parsed_json1['access_token'];
		$token = trim($token,'"');
		echo '<span STYLE="color: orange;">'.$token.'</span></pre>';
		echo '<script>parent.myform.token.value="'.$token.'";</script>';
	}
	else {
		echo '<pre><span STYLE="color: red; font-size: 10pt">';
		echo 'Failed to call ' . $url1 . '<br/>';
		echo 'with: ' . $data_string . '<br/><br/>Returned http '. $httpstatus1 .' error is :<br/>';
		print_r ($result1) . '</br>';
		echo '</span></pre><br/>';
	}
		curl_close($ch);	// Closing

}

?>

<body>
	<div>
		<form id="myform" action="" method="post">
			ClientId&nbsp;<input type="text" name="clientId" id="clientId" maxlength="50" size="50" value="" placeholder="Enter ClientID from your OrangePartner App" style="text-align: center;"><br/>
			ClientSecret&nbsp;<input type="text" name="clientSecret" id="clientSecret" maxlength="50" size="50" value="" placeholder="Enter ClientSecret from your OrangePartner App" style="text-align: center;"><br/>
			<input type="button" value="Step 1 - Generate Consumer_key" title="click here to generate your Base64 consumer key"
			onClick="consumerkey.value=btoa(clientId.value.trim()+':'+clientSecret.value.trim());consumerkey.select();" />
			<br/>
			Consumer_key&nbsp;<input type="text" size="100" name="consumerkey" id="consumerkey" placeholder="generated consumer key will stand here" readonly="1" />
			
			<br/><br/>
			<input type="Submit" name="btnSubmit" id="btnSubmit" value="Step 2 - Generate Token" onclick="return validateForm();">
			</form>
	</div>
</body>
</html>