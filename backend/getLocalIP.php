<?php
/**
 * 搭建本地环境 获取本机IP地址
 */
$server = 'http://xxx.com/admin.php';
$agent = $_SERVER['HTTP_USER_AGENT'];
$os = '';
if (strpos($agent, 'Macintosh') !== false) {
	$os = 'mac'; 
}else{
	$os = 'win';
}
switch ($os) {
	case 'mac':
	    uploadMacIP();
		break;
	case 'win':
		uploadWinIP();
	default:
		echo '未知操作系统类型';
		break;
}

function uploadMacIP()
{
	exec("whereis ifconfig",$out);
	$command = $out[0]." en0";
	exec($command, $output);
	$ip = '';
	foreach ($output as $k => $v) {
		if(preg_match("/inet [0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/", $v, $matches)){
			if($matches[0]){
				$ip = str_replace("inet ", "", $matches[0]);
			}
		}
	}
	if(!empty($ip)){
		uploadIP($ip,'mac');
	}
}
function uploadWinIP()
{
	$command = "ipconfig";
	exec($command, $output);
	$ip = '';
	foreach ($output as $k => $v) {
		if(preg_match("/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/", $v, $matches)){
			if($matches[0]){
				$ip = $matches[0];
			}
		}
	}
	if(!empty($ip)){
		uploadIP($ip,'win');
	}
}
function uploadIP($ip,$os)
{
	$type = ['mac'=>1,'win'=>2];
	$data = [
		'ip' => $ip,
		'type' => $type[$os],
	];
	$url = $server.'/add-ip';

	if(curl_post($url, $data)){
		echo '<h1>IP地址上传成功</h1>';
	}else{
		echo '<h1>IP地址上传失败</h1>';
	}
}
function curl_post($url,$data)
{
	$url .= "?data=".json_encode($data);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$server_output = curl_exec($ch);
	$info = curl_getinfo($ch);

	curl_close($ch);
	if($server_output == "OK"){
		return true;
	}else{ 
		var_dump($server_output);
		return false;
	}
}
?>