<?php

function query ($query)
{
	$result = mysql_query($query);

	if (!$result) 
	{
	echo('Invalid query: ' . mysql_error());
	}		
						
	return $result;
}

?>