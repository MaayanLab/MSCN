<?php 
	session_start();
	include("applet/WordCloud.php");
	include_once("database_connection.php");

	if (!isset($_SESSION['sessionid']))
	{
		$_SESSION['sessionid'] = session_id();
	}
    
    if (!isset($_SESSION['width']))
    {
        $_SESSION['width'] = 700;
    }
        
    if (!isset($_SESSION['height']))
    {
        $_SESSION['width'] = 600;
    }
	
	if (isset ($_GET['author']))
	{
		$_SESSION['author'] = stripslashes($_GET['author']);
	}
	else
	{
		$_SESSION['author'] = "MA'AYAN AVI A";
	}
	
	$query = "SELECT * FROM wordclouds_authors WHERE name = '".mysql_escape_string($_SESSION['author'])."'";

	//echo $query;
		
	$result = mysql_query($query);

	while ($row = mysql_fetch_assoc($result)) 
	{
		$keywords_list = $row["keywords_list"];
	}
	mysql_free_result($result);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
		<meta name="description" content="Stem Cells database"/>
		<meta name="keywords" content="network, co-authorship, lab, web application."/>
		<meta name="author" content="Caroline Baroukh"/>
		<meta name="location" content="Mount Sinai Medical School,New York"/>
		<title>Mount Sinai Lab Network</title>
        <link rel="icon" type="image/png" href="images/MSLNfavicon.png">
	 	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="Style/index.css" />
	 	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="Style/wordcloud.css" />
        <link rel="stylesheet" type="text/css" href="Style/jquery.autocomplete.css" />
        <link rel="stylesheet" type="text/css" href="Style/search_bar.css" />
	</head>

	<body>
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type='text/javascript' src='js/jquery.bgiframe.min.js'></script>
        <script type='text/javascript' src='js/jquery.ajaxQueue.js'></script>
        <script type='text/javascript' src='js/thickbox-compressed.js'></script>
        <script type='text/javascript' src='js/jquery.autocomplete.js'></script>
		<script type="text/javascript">
		      $(document).ready(function() {
				//alert("OK");
				var val = ("textarea#author").val();
				alert(val);
					document.getElementById("author").autocomplete('autocomplete.php?', {
		                autoFill: true,
		                delay: 200,
		                max: 0,
		                multiple: false, 
		                mustMatch: false,
		            });
		       });
		 </script>
		<script type="text/javascript">
			function affiche(str){
				$.ajax({
				url: "get_origin_words.php?author=<?php echo $_SESSION['author'];?>&str="+str,
				success: function(data){
				   document.getElementById('appletData_1').innerHTML = data;
				}
				});
			};	
        </script>
        
		<div id="header">
            <div id="logo">
                <a href="index.php">
                    <img class="logo" border="0" src="images/MSLNlogo.png" height="60px">
                    <h1> Mount Sinai Collaboration Network </h1> 
                </a>
            </div>
		</div>
		<div id="top">
            <div id="menu">
                <ul>
                    <li><a href="index.php">NETWORK</a></li>
					<li class="select">WORDCLOUD</li>
                    <li> <a href="help.php">HELP</a> </li>
                </ul>
            </div>
        </div>
        
		<div id="corpus">
            <p> This page shows you the wordcloud for a given faculty member of Mount Sinai.<br/>
                Please be patient, sometimes the display of the wordcloud takes time.
            </p> 
			<div id="form_author">
				<form method="get" action="wordcloud.php">
				<input type="text" id="author" size="30" name="author" onclick="value=''" onblur="if (!value) value='Lastname Firstname Initials'" value="<?php echo $_SESSION['author'];?>"/><br/>
					<input type="submit" value="Create WordCloud"/>
				</form>
			</div>
			<div id="informations_origins">
			<h4>WordCloud for <?php echo $_SESSION['author']; ?></h4>
			</div>
			<div id = "wordcloud">
			<?php
				create_wordcloud_weights('1', 'applet/', $keywords_list);
			?>
			</div>
				
		</div>
		<div class="clear">
		<p>&nbsp;</p>
		</div> 
		<div id="footer">
            <div id="contact">
                <a href="mailto:avi.maayan@mssm.edu"> <img src="images/enveloppe.jpg" height="12px;" border="0" /> Contact us</a>
            </div>
            <div id="links">
                <ul> 
                    <li> <a href="http://www.mountsinai.org/Research/Centers%20Laboratories%20and%20Programs/Maayan%20Laboratory">Ma'ayan Laboratory</a> </li>
                    <li> <a href="http://www.sbcny.org">Systems Biology Center New York</a> </li>
                    <li> <a href="http://www.mountsinai.org/Education/School%20of%20Medicine">Mount Sinai School of Medicine</a> </li>
                </ul>
            </div>
		</div>
	</body>
</html>
