<?php 
	session_start();
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
	 	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="Style/help.css" />
        <link rel="stylesheet" type="text/css" href="Style/jquery.autocomplete.css" />
        <link rel="stylesheet" type="text/css" href="Style/search_bar.css" />
	</head>

	<body>
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type='text/javascript' src='js/jquery.bgiframe.min.js'></script>
        <script type='text/javascript' src='js/jquery.ajaxQueue.js'></script>
        <script type='text/javascript' src='js/thickbox-compressed.js'></script>
        <script type='text/javascript' src='js/jquery.autocomplete.js'></script>
        
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
					<li><a href="wordcloud.php">WORDCLOUD</a></li>
                    <li class="select"> HELP</li>
                </ul>
            </div>
        </div>
        
		<div id="corpus">
            <div id="menu2">
                <p>
                    <span class="submenu"><a href="#presentation">Introduction</a></span>
                     <span class="submenu"><a href="#troubleshooting">Troubleshooting</a></span>
                     <span class="submenu"><a href="#embed_applet">WordCloud Applet</a></span>
                     <span class="submenu"><a href="#contacts">Contact</a></span>
					<span class="submenu"><a href="#references">References</a></span>
                </p>
            </div>
			<div id="presentation">
				<h3>Presentation</h3>
				<p></p>
			</div>
			<div id="embed_applet">
				<h3>WordCloud Applet</h3>
				<p>If you want more details about how works the WordCloud applet or if you want to embed the applet in your own website, please visit <a href="maayanlab.net/G2W">Genes2WordCloud</a>.
			</div>
			<div id="troubleshooting">
			   <h3>Troubleshooting</h3>
			    <h4>WordCloud not showing?</h4>
			        <p> There are three possible explanations:
			          	<ul>
			                <li>Java is not working on your computer or within your browser. In this case, to verify and solve the problem, go <a href="http://www.java.com/en/download/testjava.jsp">here.</a> </li>
			                <li>No terms were found with your input. Normally you should receive a warning message. In some cases try to remove punctuations, symbols, or other similar characters, or verify that you entered correct gene names. </li>
			                <li>Check that the color of the words is different from the background-color. White words on a white background won't be visible.</li>
			            </ul>
			                If it still doesn't work, you can try to figure out the error by opening the java console on your computer. To do this click <a href="http://www.java.com/en/download/help/javaconsole.xml">here</a>.
			                <br/> Send <a href="mailto:avi.maayan@mssm.edu;caroline.baroukh@mssm.edu"> us</a> the content of the java console, along with the type of WordCloud you tried to display and the input you used. We will try to debug the error and get back to you.
			        </p>
				<h4>Network Not Showing?</h4>
				<p>If you don't see the network when using the network generator, make sure that you have flash installed. The Flash plug-in is freely available from <a href="http://www.adobe.com/software/flash/about/">Adobe.</a><p>
				<h4>Your name is missing? Missing publications?</h4>
				<p><em>Only faculty members</em> of Mount Sinai Medical Center and publications from the <em>last five years</em> appear in the network. <br/>
					If you are a faculty member and your name and/or publications are missing, please <a href="mailto:avi.maayan@mssm.edu">contact us</a>.</p>
			</div>
			<div id="contacts">
				<h3>Any Questions And Suggestions</h3>
				<p>Please, <a href="mailto:avi.maayan@mssm.edu">contact us</a> if you have any questions or suggestions.</p>
			</div>
			<div id="references">
			   <h3>References</h3>
                <ul>
					<li> <a href="http://cytoscapeweb.cytoscape.org/">Cytoscape Web: an interactive web-based network browser,</a>Lopes CT, Franz M, Kazi F, Donaldson SL, Morris Q, Bader GD, Bioinformatics. 2010 Sep 15;26(18):2347-8.</li>
                    <li>Visual Presentation as a Welcome Alternative to Textual Presentation of Gene Annotation Information, Jairav Desai, Jared M. flatow, Jie Song, Lihua J. Zhu, Pan Du, Chiang-Ching Huang, Hui Lu, Simon M. Lin, and Warren A. Kibbe, Advances in computational biology, 2010, pages 709-715, Springer.</li>
                    <li><a href="http://www.wordle.net/">Wordle</a>, Jonathan Feinberg, 2009</li>
                    <li><a href="http://processing.org/">Processing librairies</a></li>
                    <li><a href="http://wordcram.wordpress.com/">WordCram, Dan Bernier</a></li>
                    <li><a href="http://www.ncbi.nlm.nih.gov/books/NBK25500/">Pubmed e-utilities</a>
                    <li><a href="http://nadeausoftware.com/articles/2008/04/php_tip_how_extract_keywords_web_page">How to extract keywords from a web page</a>, Dr. David R. Nadeau</li>
                </ul>
                </p>
            </div>	
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
