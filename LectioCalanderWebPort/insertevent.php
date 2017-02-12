<?php
function insertevent($eventarray, $calendarId, $service){
  $numberofevents = count($eventarray[0]);
  for ($i = 0; $i < $numberofevents; $i++){
      $event = new Google_Service_Calendar_Event(array(
    'summary' => "{$eventarray[2][$i]}",
    'description' => "{$eventarray[12][$i]}",
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
  $service->events->insert($calendarId, $event);
  }
}
?>