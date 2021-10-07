<?php 




//error reporting for testing. uncomment next line to see errors
//ini_set('error_reporting', E_ALL);


//setting dates in correct format for today and next 2 days
//You can make this run for more days by making more variables for more days

	$today= date('Y-m-d');
		
	$tomorrow= date('Y-m-d', strtotime($today. ' + 1 days'));

	$enddate= date('Y-m-d', strtotime($today. ' + 2 days'));

	
//setting day of week for next two days

$tomorrowday= date('l', strtotime($today. ' + 1 days'));
	

	
	$twodaysout = date('l', strtotime($today. ' + 2 days'));

//using 1.1 API

$token_url = "https://eiu.libcal.com/1.1/oauth/token";

//replace Xs with the location ID you want hours for

$test_api_url = "https://eiu.libcal.com/api/1.1/hours/XXXXXXX?&from=$today&to=$enddate";


//	client (application) credentials. Find/create this in libcal admin under API 
$client_id = "XXX";
$client_secret = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";


function getAccessToken() {
	global $token_url, $client_id, $client_secret;

	$content = "grant_type=client_credentials";
	$authorization = base64_encode("$client_id:$client_secret");
	$header = array("Authorization: Basic {$authorization}","Content-Type: application/x-www-form-urlencoded");

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $token_url,
		CURLOPT_HTTPHEADER => $header,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $content
	));
	$response = curl_exec($curl);
	curl_close($curl);

	return json_decode($response)->access_token;
}

	$access_token = getAccessToken();





	$header = array("Authorization: Bearer {$access_token}");

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $test_api_url,
		CURLOPT_HTTPHEADER => $header,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true
	));
	$response = curl_exec($curl);
	if(!$response){die("Connection Failure");}
	

	

	
	
   curl_close($curl);
   
//for testing. Uncomment to see ray JSON
//echo $response;
   
	
    $array = json_decode($response, true);
 
//uncomment this to see the array
// print_r($array);     
  



echo "<p><ul><li>Today: <span class=\"smaller\"> ";
	

$status= $array[0]['dates'][$today]['status'];

//check if status not open

if ($status!=="open")
	
{echo "Closed";}

//echo hours 

else
	{
	
	foreach($array[0]['dates'][$today]['hours']as $key => $value){
			
			
			
		
				
				$from=$value['from'];
					
				$to=$value['to'];
			if ($to=="12:00am")
			{$to="Midnight";}
			
			
			echo $from;
	echo "-";
		echo $to;}}
	
	echo "</span></li><li>";
	
	
	echo $tomorrowday;
	echo ": <span class=\"smaller\">";

$status= $array[0]['dates'][$tomorrow]['status'];

if ($status!=="open")
	
{echo "Closed";}

else
	{
	
	foreach($array[0]['dates'][$tomorrow]['hours']as $key => $value){
			
				
		
				
				$from=$value['from'];
					
				$to=$value['to'];
			if ($to=="12:00am")
			{$to="Midnight";}
			
			
			echo $from;
	echo "-";
		echo $to;
	
	
	}	}

	
	echo "</span></li><li>";
	echo $twodaysout;
	echo ": <span class=\"smaller\">";

$status= $array[0]['dates'][$enddate]['status'];

if ($status!=="open")
	
{echo "Closed";}

else
	{
	
	foreach($array[0]['dates'][$enddate]['hours']as $key => $value){
			
			
			
		
				
				$from=$value['from'];
					
				$to=$value['to'];
			if ($to=="12:00am")
			{$to="Midnight";}
			
			
			echo $from;
	echo "-";
		echo $to;}
	echo "</span></li>";
	echo "</ul></p>";}	

?>

 
