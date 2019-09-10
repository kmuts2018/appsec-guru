<?php

/////////////////////////
// Part B - getting the issues

$postinfo2 = "query=Application Name%3DMigros 2&columns=status,cvss,issuetype,location,severity&sortBy=-id&dojo.preventCache=1453360377756";

$posturl2="https://appscan87.appscan.training.com:9443/ase/api/issues/" . $appscanissueid . "/application/1/"    ;

$posturl2 = str_replace(" ","%20",$posturl2);

	// TESTING - TO BE REMOVED
	//$posturl2='https://appscan87:9443/ase/api/issues/932/application/4/';

	print "<p>Printing porturl2: " . $posturl2 ;

	// convert cookie array to atring
	$cookies = implode ($cookies);
	
$headers2 = array(    "Accept-Encoding: gzip",
                     "Content-Type: application/json",
					 "dataType: json",
					"Asc_xsrf_token: $asc_session_id"
					);

	
	print "<p>Printing array headers2:    " ;
		print_r($headers2);
		
		
$ch2 = curl_init();
  
curl_setopt($ch2, CURLOPT_HEADER, 0);
curl_setopt($ch2, CURLOPT_NOBODY, 0);
curl_setopt($ch2, CURLOPT_URL, $posturl2);
curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, 0);

curl_setopt($ch2, CURLOPT_COOKIEFILE, $cookie_jar);
//set the cookie the site has for certain features, this is optional
curl_setopt($ch2, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers2);
$reply2 = curl_exec($ch2);

//Delete cookie file to prevent disk filling up:
unlink($cookie_jar);


print "<p>Dispalying RAW JSON contents of response with issues: <p>";					 
	var_dump ( $reply2 );

//convert json object to php associative array	
$reply2jsonarray = json_decode($reply2, TRUE);
	print "<p>Dispalying reply2jsonarray: <p>";
		print_r($reply2jsonarray);
		
// Prepare the exit variable:
	$issuedump = array ( 'id' => $appscanissueid, 'issue' => $reply2, 'issuebase64' => '' );
	
print "<p>Dispalying DECODED and ARRAYED contents of response with issues: <p>";
	
$reply2htmldecodedarray = json_decode(html_entity_decode($reply2), true) ;
$reply2plainarray = json_decode($reply2, true) ;
$reply2plainarraysort = sort ( $reply2plainarray ) ;


print "<p>Dispalying SORTED array : <p>";					 
	//print_r ( $reply2plainarraysort );

print "<h>";


/**
print "<p>Dispalying DECODED and ARRAYED contents of response with issues: <p>";					 
	//print_r ( $reply2htmldecodedarray );

	print "<p>Trying to print HTML table: <p>" ;
	
function print_row(&$item) {
  echo('<tr>');
  array_walk($item, 'print_cell');
  echo('</tr>');
}

function print_cell(&$item) {
  echo('<td>');
  echo($item);
  echo('</td>');
}
**/

?>

<table>
  // <?php array_walk($reply2htmldecodedarray, 'print_row');?>
</table>