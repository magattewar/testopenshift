<html>
<head>
	<meta charset="utf-8">
	<title>SMS API - Orange Fab Demo Day</title>
	<link rel="stylesheet" type="text/css" media="all" href="css/intro.css?v=0.1" />
</head>
<body>
<br/>

<?php

include 'variables.php';
echo '<hr>';

// CONTRACT INFORMATIONS
$url1 = $urlGetContracts;
$ch = curl_init();  //  Initiate curl
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Disable SSL verification
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
curl_setopt($ch, CURLOPT_SSLVERSION,1);  
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_GET["token"]));
curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Will return tde response, if false it print tde response
curl_setopt($ch, CURLOPT_URL,$url1);  // Set tde url
$result1=curl_exec($ch);  // Execute
$httpstatus1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_errno = curl_errno($ch);
$curl_error = curl_error($ch);
if ($curl_errno > 0) {
		echo "<br/>cURL Error ($curl_errno): $curl_error\n<br/><br/>";
}
$parsed_json1 = json_decode($result1, true);
curl_close($ch);  // Closing
echo '<span STYLE="color: orange; font-size: 10pt">'.$url1.'</span><br/><br/>';

if ($httpstatus1 == '200') {
	if(empty($parsed_json1['partnerContracts']['contracts'])){
		$contractsList = 'No contract yet purchased for this partner';
	}
	else{
		$contractsList = $parsed_json1['partnerContracts']['contracts'][0]['contractDescription'] . "<br/>";
		//$contractsList = '';

		foreach ($parsed_json1['partnerContracts']['contracts'][0]['serviceContracts'] as $serviceContracts) {
			//echo "<br/>";
			$contractsList = $contractsList . $serviceContracts['scDescription'] . "<br/>";
		}
	}
	echo $contractsList;
}
else {
	echo '<br/><span STYLE="color: red; font-size: 10pt">';
	echo 'Failed to call ' . $url1 . '<br/>';
	echo '<br/>Returned http '. $httpstatus1 .' error is :<br/>';
	print_r ($result1) . '</br>';
	echo '</span><br/>';
}

echo '<br/>';
echo '<hr/>';


// STATS USAGE INFORMATIONS
$url2 = $urlGetStatistics;
$ch = curl_init();  //  Initiate curl
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Disable SSL verification
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  
curl_setopt($ch, CURLOPT_SSLVERSION,1);  
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_GET["token"]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Will return tde response, if false it print tde response
curl_setopt($ch, CURLOPT_URL,$url2);  // Set tde url
$result2=curl_exec($ch);  // Execute
$httpstatus2 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_errno = curl_errno($ch);
$curl_error = curl_error($ch);
if ($curl_errno > 0) {
		echo "<br/>cURL Error ($curl_errno): $curl_error\n<br/><br/>";
}
curl_close($ch);  // Closing

$parsed_json2 = json_decode($result2, true);

echo '<span STYLE="color: orange; font-size: 10pt">'.$url2.'</span><br/><br/>';

if ($httpstatus2 == '200') {
	if(empty($parsed_json2['partnerStatistics']['statistics'])){
		$statsList = 'No SMS yet sent for this partner';
	}
	else{
		$statsList = '<table border="1" align="center">';
		foreach ($parsed_json2['partnerStatistics']['statistics'][0]['serviceStatistics'] as $countryStatistics) {
			$statsList = $statsList . "<tr><th colspan='2'>" . $countryStatistics['country']. "</th></tr>";
			$statsList = $statsList . "<tr><th>applicationId</th><th>usage</th></tr>";
			foreach ($countryStatistics['countryStatistics'] as $apps){
				$statsList = $statsList . "<tr><td>" . $apps['applicationId'] . "</td><td>" .  $apps['usage'] . "</td></tr>";
			}
		}
		$statsList = $statsList . '</table>';
	}
	echo $statsList;
}
else {
	echo '<br/><span STYLE="color: red; font-size: 10pt">';
	echo 'Failed to call ' . $url2 . '<br/>';
	echo '<br/>Returned http '. $httpstatus2 .' error is :<br/>';
	print_r ($result2) . '</br>';
	echo '</span><br/>';
}

echo '<br/>';
echo '<hr/>';


// PURCHASED INFORMATIONS
$url3 = $urlGetPurchaseorders;
$ch = curl_init();  //  Initiate curl
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Disable SSL verification
curl_setopt($ch, CURLOPT_SSLVERSION,1);  
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$_GET["token"]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Will return tde response, if false it print tde response
curl_setopt($ch, CURLOPT_URL,$url3);  // Set tde url
$result3=curl_exec($ch);  // Execute
$httpstatus3 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_errno = curl_errno($ch);
$curl_error = curl_error($ch);
if ($curl_errno > 0) {
		echo "<br/>cURL Error ($curl_errno): $curl_error\n<br/><br/>";
}
curl_close($ch);  // Closing

$parsed_json3 = json_decode($result3, true);

echo '<span STYLE="color: orange; font-size: 10pt">'.$url3.'</span><br/><br/>';

if ($httpstatus3 == '200') {
	if(empty($parsed_json3['purchaseOrders'])){
		$poList = 'No bundle yet purchased';
	}
	else{
		$poList = '<table border="1" align="center">';
		$poList = $poList . '<tr><th>date</th><th>poId</th><th>country</th><th>bundleId</th><th>msisdn</th><th>amount</th><th>currency</th></tr>';
		
		foreach ($parsed_json3['purchaseOrders'] as $po) {
			$poList = $poList . "<tr>";
			$poList = $poList . "<td>" . $po['orderExecutioninformation']['date']. "</td>";
			$poList = $poList . "<td>" . $po['purchaseOrderId']. "</td>";
			$poList = $poList . "<td>" . $po['orderExecutioninformation']['country']. "</td>";
			$poList = $poList . "<td>" . $po['bundleId']. "</td>";
			$poList = $poList . "<td>" . $po['inputs'][0]['value']. "</td>";
			$poList = $poList . "<td>" . $po['orderExecutioninformation']['amount']. "</td>";
			$poList = $poList . "<td>" . $po['orderExecutioninformation']['currency']. "</td>";
			$poList = $poList . "</tr>";
		}
		$poList = $poList . '</table>';
	}
	echo $poList;
}
else {
	echo '<br/><span STYLE="color: red; font-size: 10pt">';
	echo 'Failed to call ' . $url3 . '<br/>';
	echo '<br/>Returned http '. $httpstatus3 .' error is :<br/>';
	print_r ($result3) . '</br>';
	echo '</span><br/>';
}

echo '<br/>';
echo '<hr/>';

echo '<span STYLE="color: gray; font-size: 10pt" align="left" text-align="left"><b>JsonGetContracts=</b>';
print_r($result1);
echo '<br/><br/>';
echo '<b>JsonGetStatistics=</b>';
print_r($result2);
echo '<br/><br/>';
echo '<b>JsonGetPurchaseorders=</b>';
print_r($result3);
echo '</span><br/>';
?>

</body>
</html>


















