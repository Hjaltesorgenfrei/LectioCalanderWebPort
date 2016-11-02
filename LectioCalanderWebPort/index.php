<?php
include ("cURLlectio.php");
$output = cURLlectio("http://www.lectio.dk/lectio/518/SkemaNy.aspx?type=elev&elevid=17544506163");
echo '<pre>';print_r($output);echo '</pre>';
?>