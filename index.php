<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>SMS API - Demo Tool</title>
	<link rel="stylesheet" type="text/css" media="all" href="css/intro.css?v=0.1" />
	<script>
		function modalWin(pagename, myparam) {
			var myWindow;
			myparam = escape(myparam);
			pagename = pagename + '?env=prod&token=' + myparam;
			document.getElementById("apiiframe").contentWindow.document.location.href=pagename;
		} 
		function validateForm(pagename) {
			var x = myform.token.value;
			if (x == null || x == "") {
				alert("Please, fill a Token !");
				return false;
			}
			else {
				modalWin(pagename,x);
				return true;
			}
		}
	</script>
</head>
<body>
	<form name="myform">
    <div class="header">
      <img src="images/logo-orange_03.png" alt="Orange" />
      <h1>SMS API - Demo Tool</h1>
    </div>
	<?php
		$token = "";
		if (isset($_GET["forcedtoken"])) {
			$token = $_GET["forcedtoken"];
		}
	?>
	<div>
		<br/>
		<a class="button" onclick="return validateForm('sendsms.php');">Send SMS API</a>
		<a class="button" onclick="return validateForm('suiviconso.php');">Admin API</a>
		<a class="button" onclick="return modalWin('token.php','');">Token Generator</a>
		<input class="token" type="text" name="token" id="token" maxlength="50" size="50" value="<?php echo $token ;?>" placeholder="token here!" style="text-align: center;">
		</div><br/>
		<iframe src="token.php" width="100%" height="400px" frameborder="0" name="apiiframe" id="apiiframe"></iframe> 
		</form>
</body>
</html>