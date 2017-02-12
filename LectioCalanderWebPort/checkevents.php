<?php
	//Old code that checks Google Calendar for events.
    $client->setAccessToken($_SESSION['access_token']);
    $service = new Google_Service_Calendar($client);
    $calendarId = 'primary';
    $optParams = array(
      'maxResults' => 10,
      'orderBy' => 'startTime',
      'singleEvents' => TRUE,
      'timeMin' => date('c'),
    );
    $results = $service->events->listEvents($calendarId, $optParams);

    if (count($results->getItems()) == 0) {
        print "No upcoming events found.\n";
    } else {
        print "Upcoming events:\n";
        foreach ($results->getItems() as $event) {
            $start = $event->start->dateTime;
            if (empty($start)) {
                $start = $event->start->date;
            }
            printf("%s (%s)\n", $event->getSummary(), $start);
        }
    }
?>