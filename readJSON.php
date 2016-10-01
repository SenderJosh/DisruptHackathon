<?php

function readJSON($filename)
{
	$file = file_get_contents($filename); 
	$result = json_decode($file, true); 
	
	// beginning time, end time, date, day of week
	$returnArray = array(); 
	
	foreach ($result['items'] as $event)
	{		
		$returnArray[] = array('start'=>
		strtotime($event['start']['dateTime']), 'end'=>
		strtotime($event['end']['dateTime'])); 
	}
	
	return $returnArray;
}

// testing purposes 
//readJSON('CG.json'); 


?>