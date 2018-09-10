<?php

include_once("database_connection.php");

if(isset($_GET['q']) and $_GET['q'] != '')
{
    $query = "SELECT * FROM index_autocomplete WHERE names REGEXP '^".$_GET['q']."'";

   // echo $query;
    
    $result = mysql_query($query);

    while ($row = mysql_fetch_assoc($result)) 
    {
       echo $row["names"]."\n";
    }
    mysql_free_result($result);
}

?>