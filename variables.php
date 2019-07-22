<?php


// debug value in the HTML forms
$inputvisibility = "hidden";  // hidden or text

// Global parameters
$env = "QUALIF";        // QUALIF  or   PROD
if (isset($_GET['env']) && $_GET['env']=="prod"){
	$env = "PROD";        // QUALIF  or   PROD
}
else {
	$env = "QUALIF";
}
$user_agent = $_SERVER['HTTP_USER_AGENT'];

// OPE URLs
$http = "https://"; //   http:// ou https://
if ($env == "QUALIF"){
	$host = "integ.api.orangeadd.com";
}
else{
	$host = "api.orange.com";
}

$port = "";
$folder = "";

$starturl = $http.$host.$port.$folder;

$urlGetContracts = $starturl."/sms/admin/v1/contracts";
$urlGetStatistics = $starturl."/sms/admin/v1/statistics";
$urlGetPurchaseorders = $starturl."/sms/admin/v1/purchaseorders";

// SMS API URLs
$senderAddressURL = "221000000000";
$urlSendSMS = $starturl . "/smsmessaging/v1/outbound/tel%3A%2B" . $senderAddressURL . "/requests";


?>

