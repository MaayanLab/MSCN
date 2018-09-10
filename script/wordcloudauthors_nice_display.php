<?php
	// This is to get the script execution time.
   $mtime = microtime();
   $mtime = explode(" ",$mtime);
   $mtime = $mtime[1] + $mtime[0];
   $starttime = $mtime;
?> 

<?php

set_time_limit(3600);

include('textmining.php');

$fw = fopen("keywords_authors_nice_display.tsv","w");
fwrite($fw,"lastname\tfirstname\tinitials\t# pmids\tpmids\tkeywords\n");
if ($handle = opendir('authors_abstracts')) 
{
	while (false !== ($file = readdir($handle))) 
	{
		if (preg_match("#.txt$#",$file))
		{
			$names = explode("_",$file);
			$initials = explode(".txt",$names[3]);
			fwrite($fw,$names[1]."\t".$names[2]."\t".$initials[0]."\t");
			$pmids = "";
			$compt_pmids = -1;
			$content = file_get_contents("authors_abstracts/".$file);
			$abstracts = explode("\n\n",$content);
			foreach ($abstracts as $abstract)
			{
				$aa = explode("\n",trim($abstract));
				$pmids .= $aa[0]." ";
				$compt_pmids++;
			}
			$pmids = substr($pmids, 0,-2);
			fwrite($fw,$compt_pmids."\t".$pmids."\t");
			$keywords = textmining_author_nice_display("authors_abstracts/".$file, "stopwords.txt", "bio-stopwords.txt", "");
			$str = "";
			foreach($keywords as $word => $occ)
			{
				$str .=$word." ".$occ." ";
			}
			$str = substr($str, 0,-1);
			fwrite($fw,$str."\n");
		}
	}
	closedir($handle);
} 
fclose($fw);

?>

<?php
	// This is to get the script execution time.
   $mtime = microtime();
   $mtime = explode(" ",$mtime);
   $mtime = $mtime[1] + $mtime[0];
   $endtime = $mtime;
   $totaltime = ($endtime - $starttime);
   echo "This page was created in ".$totaltime." seconds";
?>