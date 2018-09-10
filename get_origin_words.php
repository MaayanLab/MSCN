<?php

include_once 'PorterStemmer.php';		

function get_pmids_quick($word, $input_text_file)
{
	$pmids_match = array();
	$text = file_get_contents($input_text_file);
	$articles = explode("\n\n",$text);
	for($i=0;$i<sizeof($articles)-1;$i++)
	{
		$pmid = explode("\n",$articles[$i]);
		$pmid = $pmid[0];
		$stem_word = PorterStemmer::Stem( $word, true );
		$pmids_match[$pmid] = preg_match_all("#".$stem_word."#i",$articles[$i],$arr);
	}
	arsort( $pmids_match, SORT_NUMERIC );
	
	
	$compt = 0;
	$cutoff = 0;
	$pmids_match_filtered = array();
	foreach ($pmids_match as $key => $val)
	{
		if ($compt==3)
		{
			$cutoff= $val;
		}
		if ($val<$cutoff)
		{
			break;
		}
		if ($val!=0)
		{
			$pmids_match_filtered[$key] = $val;
		}
		$compt++;
	}

	//print_r($pmids_match_filtered);
	return $pmids_match_filtered;
}

session_start();

if (isset($_GET["str"])&&isset($_GET["author"]))
{
	$infos = explode(": ",$_GET["str"]);
	$word = $infos[0];
	$weight = $infos[1];
	$author = stripslashes($_GET["author"]);
	
	$pmids = get_pmids_quick($word,"authors_abstracts/abstracts_".preg_replace("# #","_",$author).".txt");
	//print_r($pmids);
	$content = "<p> Word: ".$word."<br/>Weight: ".$weight."<br/><table><tr><th>PubMed Id</th><th>Occurence of the word</th></tr>";
	foreach ($pmids as $pmid => $occ)
	{
		$content .= "<tr><td><a href=\"http://www.ncbi.nlm.nih.gov/pubmed?term=".$pmid."\" target=\"_blank\">".$pmid ."</a></td><td>".$occ."</td></tr>";
	}
	$content .= "</table></p>";
	echo $content;
			
}

?>