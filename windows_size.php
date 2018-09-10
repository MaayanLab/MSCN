<?php
    session_start();
    if (isset($_GET["width"]))
    {
        $_SESSION["width"] = round($_GET["width"]*0.70*0.75-40);
        $_SESSION["height"] = round($_SESSION["width"]*0.75);
    }
    else
    {
        $_SESSION["width"] = 700;
        $_SESSION["height"] = 600;
    }
    echo $_SESSION["width"];
?>

