<?php
function cURLlectio($url){
    $url = "$url";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //Doesnt verify the servers ssl. As it could make it fail if lectio's ssl runs out.
    $output = curl_exec($ch);
    curl_close($ch);

    $regexpattern = '((\btitle[=]\")(.*(?<!Aflyst\!)\n)?(.*(?<!Aflyst\!)\n)?((\d{1,2})\/(\d{1,2})-(\d{4})\s(\d{2}):(\d{2})\s\btil\s(\d{2}):(\d{2}))\n(\bHold:.*?\n.*?\n.*?)?\n)';
    preg_match_all($regexpattern, $output, $regexresults);
    return $regexresults;
}
?>

