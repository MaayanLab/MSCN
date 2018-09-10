<?php

$db_name = 'maaya0_mountsinai_pub';

//Connection to the databse
$link = mysql_connect('localhost', $USER, $PASSWORD);
if (!$link) 
{
    die('Could not connect: ' . mysql_error());
}

$db_selected = mysql_select_db($db_name, $link);
if (!$db_selected) 
{
    die ('Can\'t use foo : ' . mysql_error());
}

?>
