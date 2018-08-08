<?php
define('API_URL', 'https://api.foursquare.com/v2/venues/explore');

Parse_Env(); // Parse the .env file to get Foursquare credentials
$FS_data_raw = Call_Foursquare($_POST['place']); // Call the Foursquare API with the user provided place name
$filtered_data = Filter_FS_Data($FS_data_raw); // Filter the data returned from Foursquare to leave just the items we're interested in
return json_encode($filtered_data); // JSON encode the filtered data and return to user's browser for display

// Call the Foursquare API with the user provided place name:
function Call_Foursquare($placename) {
	$FS_URL = $API_URL."?near=".$placename."&client_id=".FOURSQUARE_CLIENTID."&client_secret=". FOURSQUARE_SECRET;

	// initiate curl
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_URL, $FS_URL);
	$result = curl_exec($curl);
	curl_close($curl);
	return $result;
}

// Filter the data returned from Foursquare to leave just the items we're interested in:
function Filter_FS_Data($raw_data) {
	$json_data = json_decode($raw_data); // Convert raw data returned from Foursquare into JSON structure we can parse
	if($json_data->response->warning) { // Pick up any warning from Foursquare if there is one
		$response['err'] = 'Error';
		$response['msg'] = $json_data->response->warning->text;
		}
	
	// Parse through the groups in the Foursquare data, extracting the info we're interested in:
	if($json_data->response->groups) {
		foreach($json_data->response->groups as $group) {
			foreach($group->items as $item) {
			
			}
		}
	
	
	
	}


}

// Get the Foursquare credentials from a .env file which we wouldn't normally commit to repo
function Parse_Env() {
$env_vars = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); // Load in the .env file
// Prse the .env file:
foreach($env_vars as $line) { // For each line
	$parts = explode('=', $line); // Separate out constant name and value
	define($parts[0], $parts[1]); // Assign as a constant
}

?>