<?php
include 'readJSON.php'; 

function monthlySum($month, $year, $filename)
{
	$result = readJSON($filename); 
	// sum is in hours 
	$sum = 0; 
	
	foreach ($result as $event)
	{
		$startDate = date("m/Y", $event['start']); 
		$comparisonDate =  date("m/Y", strtotime($month . '/01/' . $year)); 
		if ($startDate == $comparisonDate)
		{
			$difference = ($event['end'] - $event['start'])/3600; 
			$sum += $difference; 
		}
	}

	return $sum; 
}
// for testing 
// monthlySum(10, 2016); 

?>