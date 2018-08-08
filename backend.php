<?php
define('API_URL', 'https://api.foursquare.com/v2/venues/explore');

$env_vars = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach($env_vars as $line) {
	$parts = explode('=', $line);

}

$FS_data = Call_Foursquare($_POST['place']);


function Call_Foursquare($placename)
{
	$FS_URL = $API_URL . "?near=" . $placename . "&client_id=" . FOURSQUARE_CLIENTID . "&client_secret=" . FOURSQUARE_SECRET;

	// initiate curl
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_URL, $FS_URL);
	$result = curl_exec($curl);
	curl_close($curl);
	return $result;
}

?>