<?php

$url = "https://www.lectio.dk/lectio/518/SkemaNy.aspx?type=elev&elevid=17544503933";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
$output = curl_exec($ch);
curl_close($ch);


$regexpattern = '((\btitle[=]\")(.{1,50}\n)?((\d{1,2})\/(\d{1,2})-(\d{4})\s(\d{2}):(\d{2})\s\btil\s(\d{2}):(\d{2}))\n(\bHold:.*?\n.*?\n.*?)?\n)';
//	$regexresults = spliti ($regexpattern, $output);
preg_match_all($regexpattern, $output, $regexresults);
echo '<pre>';print_r($regexresults);echo '</pre>';
?>