<?php
function cURLlectio($url){
	//Initializes Curl
    $ch = curl_init($url);
	//Makes Curl return the html it reaches on the server.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //Doesnt verify the servers ssl. As it could make it fail if lectio's ssl runs out.
    //Sets output to the result of the Curl Execution.
	$output = curl_exec($ch);
    curl_close($ch);
	//A mother of a regexpattern
    $regexpattern = '((\btitle[=]\")(.*(?<!Aflyst\!)\n)?(.*(?<!Aflyst\!)\n)?((\d{1,2})\/(\d{1,2})-(\d{4})\s(\d{2}):(\d{2})\s\btil\s(\d{2}):(\d{2}))\n(\bHold:.*?\n.*?\n.*?)?\n)';
    /*
	Matches on:
	title="Ændret!
	31/1-2017 08:15 til 09:00
	Hold: S2q KE
	Lærer: Morten Rimmen Pedersen (mrp)
	Lokale: 242
	
	and seperates it into groups like this.
	
	1:title="((\btitle[=]\")
	2&3:(.*(?<!Aflyst\!)\n)?(.*(?<!Aflyst\!)\n)? which doesnt get saved, its just to remove lections that is cancelled.
	4:31/1-2017 08:15 til 09:00 ((\d{1,2})\/(\d{1,2})-(\d{4})\s(\d{2}):(\d{2})\s\btil\s(\d{2}):(\d{2}))
	4.1:31		(\d{1,2})
	4.2:1 		(\d{1,2})
	4.3:2017	(\d{4})
	4.4:08  	(\d{2})
	4.5:15	    (\d{2})
	4.6:09		(\d{2})
	4.7:00		(\d{2})
	5:Matches the next 3 lines which is: (\d{2}))\n(\bHold:.*?\n.*?\n.*?)?\n
		Hold: S2q KE
		Lærer: Morten Rimmen Pedersen (mrp)
		Lokale: 242
	*/
	
	//matches all matches in curl output and puts in an 2d array.
    preg_match_all($regexpattern, $output, $regexresults);
    return $regexresults;
}
?>