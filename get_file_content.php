<?php

session_start();

if (!isset($_SESSION['sessionid']))
{
    $_SESSION['sessionid'] = session_id();
}

if (isset($_GET['network'])&&$_GET['network']!="whole_network")
{
	$fr= fopen("networks/departments/co_authors_network_".preg_replace("#_#"," ",$_GET['network'])."_dpts_colors.xgmml","r");
}
else if (isset($_GET['network'])&&$_GET['network']=="whole_network")
{
	$fr= fopen("networks/departments/co_authors_network.xgmml","r");
}
else
{
	//$fr= fopen("networks/departments/co_authors_network_Psychiatry_dpts_colors.xgmml","r");
	$fr= fopen("networks/departments/co_authors_network.xgmml","r");
}

while ($line= fgets ($fr)) {
   echo($line);
}
fclose($fr);
    

?>