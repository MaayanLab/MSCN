<?php 
	session_start();
	
    set_time_limit('280');
    
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
	 	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="Style/network.css" />
        <link rel="stylesheet" type="text/css" href="Style/jquery.autocomplete.css" />
        <link rel="stylesheet" type="text/css" href="Style/search_bar.css" />
	</head>

	<body>
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type='text/javascript' src='js/jquery.bgiframe.min.js'></script>
        <script type='text/javascript' src='js/jquery.ajaxQueue.js'></script>
        <script type='text/javascript' src='js/thickbox-compressed.js'></script>
        <script type='text/javascript' src='js/jquery.autocomplete.js'></script>
        
        <script type="text/javascript" src="js/json2.min.js"></script>
        <script type="text/javascript" src="js/AC_OETags.min.js"></script>
        <script type="text/javascript" src="js/cytoscapeweb.min.js"></script>
        
       <script type="text/javascript">
       $(document).ready(function() {
            $.ajax({
                url: "windows_size.php?width="+$(window).width(),
                success: function(data){
                   document.getElementById('flashcytoscape').style.width=data+"px";
                   document.getElementById('flashcytoscape').style.height=data*0.75+"px";
                }
            });
			$("#searchnode").autocomplete('autocomplete.php?', {
                autoFill: true,
                delay: 200,
                max: 0,
                multiple: false, 
                mustMatch: true,
            });	
        });
        </script>
        
        <script type="text/javascript">
            $(document).ready(function() {
				//$("body").css("cursor") = "wait";
				$("#message").html("<h4>Please wait</h4>");
                var div_id = "flashcytoscape";
                
                var options = {
                    swfPath: "flash/CytoscapeWeb",
                    flashInstallerPath: "flash/playerProductInstall"
                };
                var network;
                var vis = new org.cytoscapeweb.Visualization(div_id, options);
				
                var layout={
                    name:"Preset"
                };
				var style = {
					nodes: {
						selectionGlowStrength: 240,
						selectionGlowColor: "#FE0000",
						selectionGlowOpacity: 1,
					},
					edges : {
						selectionGlowStrength: 150,
						selectionGlowOpacity: 0.8,
					}
					}; 
				$.ajax({
                    url: "get_file_content.php",
                    success: function(data){
                        network = data;
                        draw(network,layout,style);
						title = $("#departments").val();
						$("#title_network").html("Mount Sinai Collaboration Network");
                    }
                });  
                
                vis.addListener("click","edges", function(evt){
                    var edge = evt.target;
                    var pmids = edge.data.label.split(" - ");
					var dpt = edge.data.departments.split(":");
					if (dpt.length>1)
					{
						var dpts = dpt[1].split("&");
						var str = dpts[0]+" <br/> &amp; <br/>"+dpts[1];
					}
					else
					{
						var str = edge.data.departments;
					}
                    var string = "<p><strong>Edge "+vis.node(edge.data.source).data.label+"-"+vis.node(edge.data.target).data.label+"</strong> <br/> Weigth: "+edge.data.weight+"<br/> Departments: <br/>"+str+"<br/><br/> Interaction type and PubMed ids: <ul>";
                    for (i=0;i<pmids.length;i++)
                    {
                        pmid = pmids[i].split(": ");
                        if (pmid[1]!=0)
                        {
                            string = string + "<li>"+pmid[0]+": <a href=\"http://www.ncbi.nlm.nih.gov/pubmed?term="+pmid[1]+"\" target=\"_blank\">"+pmid[1]+"</a></li>";
                        }
                        else
                        {
                            string = string + "<li>"+pmid[0]+": "+pmid[1]+"</li>";
                        }
                    }
                    string = string + "</ul></p>";
                    $("#infos").html(string);
                });
				vis.addListener("click","nodes", function(evt){
                    var node = evt.target;
					document.getElementById("searchnode").value = node.data.label;
					temp = [node];
					var neighbors = vis.firstNeighbors(temp);
                    var string = "<p><strong>Node "+node.data.label+"</strong> <br/> Degree: "+neighbors.neighbors.length+"<br/> Departments: "+node.data.departments+"</p>";
                    $("#infos").html(string);
                });
				vis.addListener("dblclick","nodes", function(evt){
					var name = document.getElementById("searchnode").value;
					var nodes = vis.nodes();
					var index = find(nodes,name);
					if (index!=-1)
					{
						location.replace('wordcloud.php?author='+encodeURI(name));
					}
					else
					{
						alert("Author not found.");
					}
                });
                
                $("#view").change(function(){
                    layout = {name: this.value};
                    vis.layout(layout);
                });

                $("#nodeLabelsVisible").change(function(){
                    if ($("#nodeLabelsVisible").is(":checked"))
                    {
                        vis.nodeLabelsVisible(true);
                    }
                    else
                    {
                        vis.nodeLabelsVisible(false);
                    }
                });
                $("#edgeLabelsVisible").change(function(){
                    if ($("#edgeLabelsVisible").is(":checked"))
                    {
                        vis.edgeLabelsVisible(true);
                    }
                    else
                    {
                        vis.edgeLabelsVisible(false);
                    }
                });
                
                $("#download_png").click(function(){
                    vis.exportNetwork("png","export_network.php?type=png");
                });
                $("#download_pdf").click(function(){
                    vis.exportNetwork("pdf","export_network.php?type=pdf");
                });
                $("#download_svg").click(function(){
                    vis.exportNetwork("svg","export_network.php?type=svg");
                });
                $("#download_xgmml").click(function(){
                    vis.exportNetwork("xgmml","export_network.php?type=xml");
                });
                $("#download_graphml").click(function(){
                    vis.exportNetwork("graphml","export_network.php?type=xml");
                });
                $("#download_sif").click(function(){
                    vis.exportNetwork("sif","export_network.php?type=sif");
                });
				$("#searchname").click(function(){	
					vis.deselect("nodes");
					vis.deselect("edges");
					vis.zoomToFit();
					var nodes = vis.nodes();
					var name = document.getElementById("searchnode").value;
					var index = find(nodes,name);
					if (index!=-1)
					{
						ids = [parseInt(index)+1];
						vis.select("nodes",ids);
						var neighbors = vis.firstNeighbors(ids);
						edges = neighbors.edges;
						vis.select("edges",neighbors.edges);
						//
						var node=vis.node(parseInt(index)+1);
						var string = "<p><strong>Node "+node.data.label+"</strong> <br/> Degree: "+neighbors.neighbors.length+"<br/> Departments: "+node.data.departments+"</p>";
						$("#infos").html(string);
					}
					else
					{
						alert("Author not found.");
					}
				});
				$("#wordcloudname").click(function(){	
					//alert('OK');
					var name = document.getElementById("searchnode").value;
					//alert(name);
					var nodes = vis.nodes();
					var index = find(nodes,name);
					if (index!=-1)
					{
						location.replace('wordcloud.php?author='+encodeURI(name));
					}
					else
					{
						alert("Author not found.");
					}
				});
				$("#authorsNetwork").click(function(){
					vis.deselect("nodes");
					vis.deselect("edges");
					vis.zoomToFit();
					var nodes = vis.nodes();
					var name = document.getElementById("searchnode").value;
					var index = find(nodes,name);
					if (index!=-1)
					{
						ids = [parseInt(index)+1];
						vis.select("nodes",ids);
						var neighbors = vis.firstNeighbors(ids);
						edges = neighbors.edges;
						vis.select("edges",neighbors.edges);
						var nodes_to_keep = new Array();
						var compt=0;
						var nodes_selected = vis.selected("nodes");
						var nb_neighbors = 1;
						
						for (var i=0; i<nodes_selected.length; i++) {
							nodes_to_keep[compt] = nodes_selected[i].data.label;
							compt++;
						}
						
						var temp = nodes_selected;
						for (var i=0; i<1; i++) {
							var neighbors = vis.firstNeighbors(temp);
							for(var j=0; j< neighbors.neighbors.length;j++)
							{
								nodes_to_keep[compt] = neighbors.neighbors[j].data.label;
								compt++;
							}
							temp = neighbors.neighbors;
						} 
						
						vis.filter("nodes", function(node){
							return (in_array(nodes_to_keep,node.data.label));
						});
						vis.zoomToFit();
						var node=vis.node(parseInt(index)+1);
						var string = "<p><strong>Node "+node.data.label+"</strong> <br/> Degree: "+neighbors.neighbors.length+"<br/> Departments: "+node.data.departments+"</p>";
						$("#infos").html(string);
					}
					else
					{
						alert("Author not found.");
					}
				});
				$("#filter").click(function(){
					var nodes_to_keep = new Array();
					var compt=0;
					var nodes_selected = vis.selected("nodes");
					var nb_neighbors = parseInt(document.getElementById('nb_neighbors').value);
					
					for (var i=0; i<nodes_selected.length; i++) {
						nodes_to_keep[compt] = nodes_selected[i].data.label;
						compt++;
					}
					
					var temp = nodes_selected;
					for (var i=0; i<parseInt(nb_neighbors); i++) {
						var neighbors = vis.firstNeighbors(temp);
						for(var j=0; j< neighbors.neighbors.length;j++)
						{
							nodes_to_keep[compt] = neighbors.neighbors[j].data.label;
							compt++;
						}
						temp = neighbors.neighbors;
					} 
					
					vis.filter("nodes", function(node){
						return (in_array(nodes_to_keep,node.data.label));
					});
					vis.zoomToFit();
				});
				$("#unfilter").click(function(){
					vis.removeFilter();
					vis.zoomToFit();
				});
				function find(arr, obj) {
					for(var i=0; i<arr.length; i++) {
					if (arr[i].data.label == obj)
					{
						return i;
					}
				  }
				  return -1;
				}
				function in_array(arr, obj) {
					for(var i=0; i<arr.length; i++) 
					{
						if (arr[i] == obj)
						{
							return true;
						}
					}
				  return false;
				}
				function draw(network,layout,style){
					$("#message").html("<h4>Please wait.</h4>");
					vis.draw({ network: network, layout: layout, visualStyle:style});
					$("#message").html("");
				}
				$("#departments").change(function() {
					$.ajax({
						url: "get_file_content.php?network="+$(this).val(),
						success: function(data){
							title = $("#departments").val();
							if (title == "whole_network")
							{
								$("#title_network").html("Mount Sinai Collaboration Network");
								var layout={
									name:"Preset"
								};
							}
							else
							{
								$("#title_network").html("Department of "+title.replace(/_/g," "));
								 var layout={
									name:"ForceDirected"
								};
							}
							network = data;
							//vis.draw({ network: network, layout: layout, visualStyle:style});
							draw(network,layout,style);
							$("#infos").html("");
						}
					}); 
				})
            });  
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
                    <li class="select">NETWORK</li>
					<li> <a href="wordcloud.php">WORDCLOUD</a> </li>
                    <li> <a href="help.php">HELP</a> </li>
                </ul>
            </div>
        </div>
        
		<div id="corpus">
            <p> This page shows you the laboratory network of Mount Sinai.<br/>
                Please be patient, sometimes the display of the network takes time.<br/><br/>
            </p> 
			<h4 id="title_network"></h4>
			<div id="message">
			</div>
			<div id="formnetwork">
				 <form onsubmit="return false;">
					 <p>
						<input type="text" id="searchnode" size="30" name="searchnode" onclick="value=''" onblur="if (!value) value='Lastname Firstname Initials'" value="Lastname Firstname Initials"/><br/><br/>
						<input type="button" id="searchname" value="Highlight author in network"/> <br/>
						<input type="button" id="authorsNetwork" value="Draw network around author"/><br/>
						<input type="button" id="wordcloudname" value="Create WordCloud"/>
						<br/><br/><br/>
						Select a node/nodes and only keep collaborators of degree <input type="text" id="nb_neighbors" size="1" name="nb_neighbors" onclick="value=''" onblur="if (!value) value='1'" value="1"/>.
						<input type="button" id="filter" value="Filter"/>
						<br/><br/><br/>
						<input type="button" id="unfilter" value="Redraw whole network"/>
						<br/><br/><br/>
					 </p>
				 </form>
					<div id="infos"> 
					</div>
			</div>
            <div id = "flashcontainer">
                <div id = "flashcytoscape">
                </div>  
				<div id="formflash">
                    <form onsubmit="return false;">
                        <p class="center">
							<label for="departments">Choose network: </label>
							<select name="departments" id="departments">
								<optgroup label="Whole network">
									<option value="whole_network">Co-authorship network</option>
								</optgroup>
								<?php	 
									if ($handle = opendir('networks/departments/')) 
									{
										while (false !== ($file = readdir($handle))) 
										{
											if (preg_match("#_departments.txt$#",$file))
											{
												echo "<optgroup label=\"".ucfirst(preg_replace("#_#"," ",substr($file,0,-4)))."\">\n";
												$content = file_get_contents('networks/departments/'.$file);
												$dpts = explode ("\n",$content);
												foreach ($dpts as $dpt)
												{
													echo "<option value=".preg_replace("# #","_",trim($dpt)).">".trim($dpt)." </option>\n";
												}
												echo "</optgroup>";
											}
										 }
										 closedir($handle);
									} 
								?>
								</select><br/>
                           <label for="view">Layout: </label>
                           <select name="view" id="view">
                                <option value="ForceDirected" selected="selected">ForceDirected</option>
                               <option value="Radial">Radial</option>
                               <option value="Circle">Circle</option>
                               <option value="Tree">Tree</option>
                           </select>
                           <br/> 
                           <input type="checkbox" name="nodeLabelsVisible" id="nodeLabelsVisible" checked="checked"/> <label for="nodeLabelsVisible">Show node labels</label><br />
                           <input type="checkbox" name="edgeLabelsVisible" id="edgeLabelsVisible" /> <label for="edgeLabelsVisible">Show edge labels</label><br/>
                            Download results in <a id="download_png" OnMouseOver="this.style.cursor='pointer'">png</a>, <a id="download_svg" OnMouseOver="this.style.cursor='pointer'">svg</a>
                                , <a id="download_pdf" OnMouseOver="this.style.cursor='pointer'">pdf</a>
                                , <a id="download_xgmml" OnMouseOver="this.style.cursor='pointer'">xgmml</a>
                                , <a id="download_graphml" OnMouseOver="this.style.cursor='pointer'">graphml</a>
                                or <a id="download_sif" OnMouseOver="this.style.cursor='pointer'">sif</a> format.
                        </p>
                    </form>
                </div>
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
