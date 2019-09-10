<?php

// include 'fx.php';


$username1 = 'APPSCAN87' ;
$username2 = 'Stu Dent' ;
$password = 'P@ssw0rd2' ;
$username12 = $username1."\\" . $username2 ;

//login form action url
$url="https://appscan87.appscan.training.com:9443/ase/api/login"; 

$postinfo = "userId=".$username1."\\".$username2."&password=".$password."&featureKey=AppScanEnterpriseUser"."&clientVersion=&clientIp=&clientHostName=";

$postinfojson = json_encode($postinfo) ;


$postinfoarray = array ( 	"userId" => "$username12", 
							"password" => "$password",
							"featureKey" => "AppScanEnterpriseUser",
							"clientVersion" => "",
							"clientIp" => "",
							"clientHostName" => "" 
						) ;


$postinfoarrayjson = json_encode ($postinfoarray) ;


	print "<p>Printing postinfoarrayjson:    " ;
	print_r ($postinfoarrayjson);


$headers = array(    "Accept-Encoding: gzip",
                     "Content-Type: application/json",
					 "dataType: json" );


$cookie_jar = tempnam('temp','cookie');

$ch = curl_init();
  
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_NOBODY, 1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
//set the cookie the site has for certain features, this is optional
////// curl_setopt($ch, CURLOPT_COOKIE, "cookiename=0");
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//////////curl_setopt($ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//////////curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $postinfo);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postinfoarrayjson);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $postinfojson);
$reply = curl_exec($ch);
curl_close($ch);



// return $reply;

print "<p>Showing RAW header information ...<p>" ;
	var_dump ( $headers);

print "<p>Showing PROCESSED header information ...<p>" ;
		list($headers, $response) = explode("\r\n\r\n", $reply, 2);
		// $headers now has a string of the HTTP headers
		// $response is the body of the HTTP response

		$headers = explode("\n", $headers);

		print_r ($headers) ;

print "<p>Processing the cookie info ... <p>";

		$result = $reply ;

		preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);

		$cookies = array();
		foreach($matches[1] as $item) {
			parse_str($item, $cookie);
			$cookies = array_merge($cookies, $cookie);
		}
		var_dump($cookies);

		// print "<p>Printing asc_session_id: " . $cookies["asc_session_id"];
		
		$asc_session_id =  trim($cookies["asc_session_id"]) ;
		$asc_sso_token =  trim($cookies["asc_sso_token"]) ;


?>