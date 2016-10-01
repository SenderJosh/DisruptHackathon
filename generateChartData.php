<?php
/* 
[1, 20, 30, 50, 1], [20, 1, 60, 80, 30], [30, 60, 1, -10, 20]
# of sets = number of y elements
each # in set is value 
order of set is which place it will be in

[][][][][][] x 24
[# of meetings, # of meetings, # of meetings]
	
//////////////////////////////////////////////////
Sample output 

7 days a week in one set for 1 time slot (1 hr)
[1, 2, 3, 4, 5, 6, 7][1, 2, 3, 4, 5, 6, 7][][][][][][][][][][][][][][][][][][][][][][]
	
*/
include 'readJSON2.php'; 

function generateChartData()
{
	$files = array('CG.json', 'COS.json', 'DCGAR.json', 'DCGN.json', 'DCGNG.json', 'DCGS.json', 'G3.json'); 
	
	$hoursArray = array_fill(0, 24, 0); 
	$i = 0; 
	
	for ($i = 0; $i < 24; $i++)
	{
		$hoursArray[$i] = array_fill(0, 7, 0); 
	}

	
	foreach ($files as $oneFile)
	{
		$array = readJSON($oneFile);
		
		
		// print_r($hoursArray); 
			
		// sort by time then day 
			// array(start=>3243223, end=>23432)	
		foreach ($array as $event)
		{
			for ($j = 0; $j < 23; $j++)
			{			
				if (date("H", $event['start']) == $j)
				{
					for ($k = 0; $k < 7; $k++)
					{
						if (date("N", $event['start']) == $k)
						{
							$hoursArray[$j][$k] += 1; 
						}
					}
				}
			}
					
			/*
			$startDate = date("m/Y", $event['start']); 
			$comparisonDate =  date("m/Y", strtotime($month . '/01/' . $year)); 
			if ($startDate == $comparisonDate)
			{
				$difference = ($event['end'] - $event['start'])/3600; 
				$sum += $difference; 
			}
			*/
		}		
	}
	

	
	echo json_encode($hoursArray); 
	
	
}
	
	
	generateChartData(); 
	
	
?>