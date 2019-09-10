<?php

// ADD COPYRIGHT AND DATE MESSAGES HERE
// COPYRIGHT (C) 2016, IBM.
// AUTHOR: ALBERT SANDE JUMBA - ALBJUMBA@KE.IBM.COM.
// DATE: 28TH-JAN-2016.
// LOCATION: NAIROBI, KENYA.
// AUTHOR: KEVIN MUTUMA KIMATHI - KKIMATHI@KE.IBM.COM.
// DATE: 10TH-FEB-2016.
// LOCATION: RIYADH, KSA.


// Connect to AppScan Issue database:
include 'dbinternal.php';

// Get running time:
$max_execution_time = ini_get('max_execution_time');
// $max_execution_time = 15; // Only for testing


	print "<p>max_execution_time is : " . $max_execution_time . "seconds";

//$start_time = date('Y-m-d H-m-s');
$start_time = strtotime('now');
$run_time = $start_time;
	print "<p>start_time is " . $start_time ;

$end_time = strtotime('+' . $max_execution_time - 10 . 'seconds') ;
	print "<p>end_time is " . $end_time ;

// Run loop while there is still time, less 10 seconds for buffer for long queries:

while ($run_time <=  $end_time)
{
	
			// Check for max idinternal, and subsequently the corresponding issue ID.
			//// $lastissueidquery = 'SELECT issueid FROM issues WHERE idinternal = MAX(idinternal)';
			// $lastissueidquery = 'SELECT MAX(idinternal) AS idinternal FROM issues';
			$lastissueidquery = 'SELECT issueid FROM issues WHERE idinternal = (SELECT MAX(idinternal) AS idinternal FROM issues)';

				print "<p>lastissueidquery is: " .$lastissueidquery. "<p>";

			if(!$result = $db->query($lastissueidquery)){   die('There was an error running the query [' . $db->error . ']'); }

			$row_cnt = $result->num_rows ;
				print "<p>row_cnt is: " .$row_cnt. "<p>";

			if ($row_cnt <= 0) 
			{
				// No results. This is the first time the app is run:
				$lastissueid[0] = 0;
			}
			else 
			{
				$lastissueid = $result->fetch_array(MYSQLI_BOTH);	
			}

			// Request AppScan Enterprise for the next issue ID
			$appscanissueid = $lastissueid['issueid'] + 1;

				print "<p>appscanissueid is : " . $appscanissueid;

			// Login into AppScan Enterprise and fetch security tokens:
			include 'appscanlogin.php' ;

			// Fetch a single issue from AppScan Enterprise:
			include 'appscanfetch.php' ;

			// Check if the return was blank (issue not yet recorded in AppScan), else record to database after encoding.
			//if (strlen($issuedump['issue']) < 10 ) // No issue
			if (strpos($reply2, 'CRWAS2162E') !== false ) // No issue
			{
				// Do nothing
				print "<p>No more new issues found in AppScan Enterprise";
			}
			else
			{
				// Encode the string
				 $issuedump['issuebase64'] = base64_encode ($issuedump['issue']);
				 
				// Insert into database
				
				/// print some values of reply2jsonarray
					print "<p>Showing some values of reply2jsonarray: " . $reply2jsonarray['fixRecommendation'].' '.$reply2jsonarray['advisory'].' '.$reply2jsonarray['attributeCollection']['attributeArray']['19']['value']['0'] . ' ' .$reply2jsonarray['attributeCollection']['attributeArray']['17']['value']['0'] . ' ' . $reply2jsonarray['attributeCollection']['attributeArray']['2']['value']['0'] ;
					// NOT WORKING // print "<p>Showing some values of reply2jsonarray: " . $reply2jsonarray[0]->'19' . ' ' .$reply2jsonarray[0]->'17' . ' ' . $reply2jsonarray[0]->'18' ;
				
				// Prepatre the variables the long way:
					$reply2jsonarray_simple = array (									
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][1]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][2]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][3]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][4]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][5]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][6]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][7]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][8]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][9]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][10]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][11]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][12]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][13]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][14]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][15]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][16]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][17]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][18]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][19]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][20]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][21]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][22]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][23]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][24]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][25]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][26]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][27]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][28]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][29]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][30]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][31]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][32]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][33]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][34]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][35]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][36]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][37]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][38]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][39]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][40]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][41]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][42]['value']['0']),
												$db->real_escape_string($reply2jsonarray['fixRecommendation']),
												$db->real_escape_string($reply2jsonarray['advisory']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][45]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][46]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][47]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][48]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][49]['value']['0']),
												$db->real_escape_string($reply2jsonarray['attributeCollection']['attributeArray'][50]['value']['0'])
											);
					// DATE formatting test:
						$reply2jsonarray_simple[5] = new dateTime($reply2jsonarray_simple[5]);
						$reply2jsonarray_simple[6] = new dateTime($reply2jsonarray_simple[6]);

					$reply2jsonarray_simple[5] = $reply2jsonarray_simple[5] -> format( "Y-m-d H:i:s") ; // date_format( $reply2jsonarray_simple[5], "Y-m-d H:i:s");
					$reply2jsonarray_simple[6] = $reply2jsonarray_simple[6] -> format( "Y-m-d H:i:s") ; // date_format( $reply2jsonarray_simple[6], "Y-m-d H:i:s");

					$fixurl=$reply2jsonarray['fixRecommendation'];
					$advisoryurl=$reply2jsonarray['advisory'];

					include 'appscanlogin.php';
					include 'dbinternal';

					$posturl3=$fixurl;
					$posturl4=$advisoryurl;
					print "<p>Printing posturl4: " . $posturl4  ;
					print "<p>Printing posturl3: " . $posturl3 ;

					// convert cookie array to atring
					$cookies = implode ($cookies);
	
					$headers3 = array(    "Accept-Encoding: gzip",
                     			"Content-Type: application/json",
					 "dataType: json",
					"Asc_xsrf_token: $asc_session_id"
					);

	
					print "<p>Printing array headers3:    " ;
					print_r($headers3);
		
		
					$ch3 = curl_init();
					$ch4 = curl_init();
  
					//For Fix Recommendation
					curl_setopt($ch3, CURLOPT_HEADER, 0);
					curl_setopt($ch3, CURLOPT_NOBODY, 0);
					curl_setopt($ch3, CURLOPT_URL, $posturl3);
					curl_setopt($ch3, CURLOPT_SSL_VERIFYHOST, 0);

					curl_setopt($ch3, CURLOPT_COOKIEFILE, $cookie_jar);
					//set the cookie the site has for certain features, this is optional
					curl_setopt($ch3, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
					curl_setopt($ch3, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers3);

					$reply3 = curl_exec($ch3);

					//For Issue Advisory Recommendation
					curl_setopt($ch4, CURLOPT_HEADER, 0);
					curl_setopt($ch4, CURLOPT_NOBODY, 0);
					curl_setopt($ch4, CURLOPT_URL, $posturl4);
					curl_setopt($ch4, CURLOPT_SSL_VERIFYHOST, 0);

					curl_setopt($ch4, CURLOPT_COOKIEFILE, $cookie_jar);
					//set the cookie the site has for certain features, this is optional
					curl_setopt($ch4, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
					curl_setopt($ch4, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch4, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($ch4, CURLOPT_HTTPHEADER, $headers4);

					$reply4 = curl_exec($ch4);

					//Delete cookie file to prevent disk filling up:
					unlink($cookie_jar);


					print "<p>Dispalying RAW JSON contents of response with Fix Reccomendation for issues: <p>";
						$fixdetails=$db->real_escape_string($reply3);					 
						//print_r($fixdetails);


					print "<p>Dispalying RAW JSON contents of response with Issue Advisory for issues: <p>";
						$issuedetails=$db->real_escape_string($reply4);					 
						//print_r($issuedetails);

				$issuedbinsertquery = "INSERT INTO `issues` (issueid, 
															issuedumpbase64,
															f1,
															f2,
															f3,
															f4,
															f5,
															f6,
															f7,
															f8,
															f9,
															f10,
															f11,
															f12,
															f13,
															f14,
															f15,
															f16,
															f17,
															f18,
															f19,
															f20,
															f21,
															f22,
															f23,
															f24,
															f25,
															f26,
															f27,
															f28,
															f29,
															f30,
															f31,
															f32,
															f33,
															f34,
															f35,
															f36,
															f37,
															f38,
															f39,
															f40,
															f41,
															f42,
															f43,
															f44,
															f45,
															f46,
															f47,
															f48,
															f49,
															f50
															) 
															VALUES 
															(
															'$issuedump[id]',
															'$issuedump[issuebase64]',
															'$reply2jsonarray_simple[1]',
															'$reply2jsonarray_simple[2]',
															'$reply2jsonarray_simple[3]',
															'$reply2jsonarray_simple[4]',
															'$reply2jsonarray_simple[5]',
															'$reply2jsonarray_simple[6]',
															'$reply2jsonarray_simple[7]',
															'$reply2jsonarray_simple[8]',
															'$reply2jsonarray_simple[9]',
															'$reply2jsonarray_simple[10]',
															'$reply2jsonarray_simple[11]',
															'$reply2jsonarray_simple[12]',
															'$reply2jsonarray_simple[13]',
															'$reply2jsonarray_simple[14]',
															'$reply2jsonarray_simple[15]',
															'$reply2jsonarray_simple[16]',
															'$reply2jsonarray_simple[17]',
															'$reply2jsonarray_simple[18]',
															'$reply2jsonarray_simple[19]',
															'$reply2jsonarray_simple[20]',
															'$reply2jsonarray_simple[21]',
															'$reply2jsonarray_simple[22]',
															'$reply2jsonarray_simple[23]',
															'$reply2jsonarray_simple[24]',
															'$reply2jsonarray_simple[25]',
															'$reply2jsonarray_simple[26]',
															'$reply2jsonarray_simple[27]',
															'$reply2jsonarray_simple[28]',
															'$reply2jsonarray_simple[29]',
															'$reply2jsonarray_simple[30]',
															'$reply2jsonarray_simple[31]',
															'$reply2jsonarray_simple[32]',
															'$reply2jsonarray_simple[33]',
															'$reply2jsonarray_simple[34]',
															'$reply2jsonarray_simple[35]',
															'$reply2jsonarray_simple[36]',
															'$reply2jsonarray_simple[37]',
															'$reply2jsonarray_simple[38]',
															'$reply2jsonarray_simple[39]',
															'$reply2jsonarray_simple[40]',
															'$reply2jsonarray_simple[41]',
															'$fixdetails',
															'$issuedetails',
															'$reply2jsonarray_simple[44]',
															'$reply2jsonarray_simple[45]',
															'$reply2jsonarray_simple[46]',
															'$reply2jsonarray_simple[47]',
															'$reply2jsonarray_simple[48]',
															'$reply2jsonarray_simple[49]',
															'$reply2jsonarray_simple[50]'												
															)
															" ;		

					
					print "<p>issuedbinsertquery is: " . $issuedbinsertquery . "<p>" ;
				
				$issuedbinsertresult = $db->query($issuedbinsertquery) ;

				// DEPRECIATED // mysqli_query($issuedbinsertquery, $dbhandle) ;
				
				if($issuedbinsertresult)
				{
					print 'Success! ID of last inserted record is : ' .$db->insert_id .'<br />';
				}
				else
				{
					die('Error : ('. $db->errno .') '. $db->error);
				} 
				

				
			}
	$run_time = strtotime('now');
}

print "<p>TOTAL RUNNING TIME IS: " ;
print $run_time - $start_time . " seconds ";

?>