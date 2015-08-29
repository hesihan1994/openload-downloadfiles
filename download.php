<?php
$c = curl_init();

$login = '03612008dbfab81c';
$key = '7-JA94Jt';
$file = $_GET["fileid"];

curl_setopt($c, CURLOPT_URL, "https://api.openload.io/1/file/dlticket?file={$file}&login={$login}&key={$key}");
curl_setopt($c,  CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($c);
$response = json_decode($response);
$output = get_object_vars($response);


$result = get_object_vars($output['result']);
$ticket = $result['ticket'];
$captcha = $result['captcha_url'];


curl_setopt($c, CURLOPT_URL, "https://api.openload.io/1/file/dl?file={$file}&ticket={$ticket}&captcha_response={$captcha}");
curl_setopt($c,  CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($c);
$response = json_decode($response);
$output = get_object_vars($response);

$downloadOutput = get_object_vars($output['result']);
$downloadLink = $downloadOutput['url'];

header("Location:  $downloadLink");

// If no File name is provided then this form is used
 $pageName = basename($_SERVER['PHP_SELF']);
// If no File name is provided then this form is used
if (empty($file)) {
echo '
<html>
	<body>
		<form action="' . $pageName . '" method="get">
		Enter the File ID: <input type="text" name="fileid"><br>
		<input type="submit">
		</form>
	</body>
</html>
';
}
?>
