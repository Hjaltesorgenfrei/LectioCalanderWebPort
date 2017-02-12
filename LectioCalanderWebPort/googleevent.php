<?php
//Google api libary
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/cURLlectio.php';
//Url from html form
$elevurl = $_POST["url"];
//starts the google session and initializes it to client
session_start();
$client = new Google_Client();
//Gets api key
$client->setAuthConfig('client_secrets.json');
//Adds scope for which pieces of google api that are going to get access.
$client->addScope(Google_Service_Calendar::CALENDAR);
//Initializes guzzleclient which is used for sending the http requests to google.
$guzzleClient = new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));
$client->setHttpClient($guzzleClient);
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
	//Starts the service
    $service = new Google_Service_Calendar($client);
	//Gets the lektionsdata from lectio through the cURLlectio function
    $eventarray = cURLlectio($elevurl);
	//sets the calendarId to the primary one in the users calendar.
	//TODO: add a way to chose the calendar
    $calendarId = 'primary';
    $numberofevents = count($eventarray[0]);
	//Inserts a event into google calendar for each lection. 
    for ($i = 0; $i < $numberofevents; $i++){
		/*
		Takes data from the eventarray created from the cURLlectio.
		12 is the name of the lection.
		2 is the part that holds the team and teacher.
		7 is day
		6 is month
		5 is the year
		8 & 9 is the start hour and minute.
		10 & 11 is the end hour and minute.
		*/
        $event = new Google_Service_Calendar_Event(array(
        'summary' => "{$eventarray[12][$i]}",
        'description' => "{$eventarray[2][$i]}",
        'start' => array(
        'dateTime' => "{$eventarray[7][$i]}-{$eventarray[6][$i]}-{$eventarray[5][$i]}T{$eventarray[8][$i]}:{$eventarray[9][$i]}:00",
        'timeZone' => 'Europe/Copenhagen',
        ),
        'end' => array(
        'dateTime' => "{$eventarray[7][$i]}-{$eventarray[6][$i]}-{$eventarray[5][$i]}T{$eventarray[10][$i]}:{$eventarray[11][$i]}:00",
        'timeZone' => 'Europe/Copenhagen',
        ),
        'reminders' => array(
        'useDefault' => FALSE,
        'overrides' => array(
            array('method' => 'popup', 'minutes' => 10),
        ),
        
        ),
    ));
	//inserts the events
    $service->events->insert($calendarId, $event);}
} else {
	//If the session doesnt have an access token redirect.
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
?>