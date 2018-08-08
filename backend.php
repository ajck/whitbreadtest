<?php
define('API_URL', 'https://api.foursquare.com/v2/venues/explore');

Parse_Env(); // Parse the .env file to get Foursquare credentials
$FS_data_raw = Call_Foursquare($_POST['place']); // Call the Foursquare API with the user provided place name
$filtered_data = Filter_FS_Data($FS_data_raw); // Filter the data returned from Foursquare to leave just the items we're interested in
return json_encode($filtered_data); // JSON encode the filtered data and return to user's browser for display

// Call the Foursquare API with the user provided place name:
function Call_Foursquare($placename) {
	$FS_URL = $API_URL."?near=".$placename."&client_id=".FOURSQUARE_CLIENTID."&client_secret=". FOURSQUARE_SECRET;

	// Initiate CURL to get the data from Foursquare API:
	$curl = curl_init();
	// Set CURL options:
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_URL, $FS_URL);
	$result = curl_exec($curl); // Call the API
	curl_close($curl); // Close the connection
	return $result; // Return raw data
}

// Filter the data returned from Foursquare to leave just the items we're interested in:
function Filter_FS_Data($raw_data) {
	$response = []; // Empty array to be filled with response data
	$results = []; // Results data sub array, inserted into $response before return

	$json_data = json_decode($raw_data); // Convert raw data returned from Foursquare into JSON structure we can parse
	if($json_data->response->warning) { // Pick up any warning from Foursquare if there is one
		$response['err'] = 'Error';
		$response['msg'] = $json_data->response->warning->text;
		}
	
	// Parse through the groups in the Foursquare data, extracting the info we're interested in:
	if(property_exists($json_data->response, 'groups')) {
		foreach($json_data->response->groups as $group) {
			if(stripos($group->type, 'recommended')) {
				foreach($group->items as $item) {
					$array_item = [];
					$array_item['name'] = $item->venue->name; // Venue name
					$array_item['address'] = $item->venue->location->address; // Venue address
					if(isset($item->venue->categories['0']) { // If this venue falls into a category
						// Get category name:
						if(property_exists($item->venue->categories['0'], 'name')) $array_item['cat_name'] = $item->venue->categories['0']->name;
						// Get category icon URL if one exists:
						if(property_exists($item->venue->categories['0'], 'icon')) {
							$array_item['icon'] = $item->venue->categories['0']->icon->prefix.$item->venue->categories['0']->icon->suffix;
						}
					}
					// No category defined, so get URL of default category icon:
					else $array_item['icon'] = 'https://foursquare.com/img/categories/building/default_88.png';
					
					$results[] = $array_item; // Add to full results data array
				}
			}
		}
	}
	
	$response['results'] = $results; // Place results into response
	return $response; // Pass the full response data array back for JSON encoding and return to user
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