<?php
include_once 'PorterStemmer.php';
include_once 'strip_text.php';

function textmining_author($input_filename, $stopwords_filename, $bio_stopwords_filename, $author)
{

	//Get the text
	$text = file_get_contents($input_filename);
	
	//strip punctuations and characters
	$text = preg_replace("#[^\w']+#"," ",$text);
	
	//Strip numbers characters
	$text = strip_numbers( $text );
	
	//Convert to lower case
	$text = strtolower( $text);
	
	//Split the text into words
	$words = explode(" ", $text);
	
	//Stem the words using PorterStemmer algorithm
	$words_non_stemmed= array();
	foreach ( $words as $key => $word )
	{
		$stem = PorterStemmer::Stem( $word, true );
	    $words[$key] = $stem;
	    if (isset ($words_non_stemmed[$stem]))
	    {
	    	if (strlen($words_non_stemmed[$stem])>strlen($word))
	    	{
	    		$words_non_stemmed[$stem]=$word;
	    	}
	    }
	    else 
	    {
	    	$words_non_stemmed[$stem] = $word;
	    }
	}
	
	//print_r($words_non_stemmed);
	
	//Remove stop words
	$stopwords = explode("\n" ,file_get_contents($stopwords_filename));
	foreach ( $stopwords as $key => $word )
	{
	    $stopwords[$key] = PorterStemmer::Stem( $word, true );
	}
	
	$words = array_diff( $words, $stopwords );
	
	//Remove other unwanted words
	$bio_stopwords = explode("\n" ,file_get_contents($bio_stopwords_filename));
	
	foreach ( $bio_stopwords as $key => $word )
	{
	    $bio_stopwords[$key] = PorterStemmer::Stem( $word, true );
	}
	 
	$words = array_diff( $words, $bio_stopwords );
	
	//Remove the name of the author
	$authors = array(PorterStemmer::Stem( $author, true ));
	 
	$words = array_diff( $words, $authors);
	
	/*
	//Replace the stemwords by the word of the shortest length for better readibility
	foreach ($words as $key => $word)
	{
		$words[$key] = $words_non_stemmed[$word];
	}
	*/
	//Count Keyword usage
	$keywordCounts = array_count_values( $words );
	
	arsort( $keywordCounts, SORT_NUMERIC );
	
	//print_r($keywordCounts);
	
	return $keywordCounts;
}

function textmining_author_nice_display($input_filename, $stopwords_filename, $bio_stopwords_filename, $author)
{

	//Get the text
	$text = file_get_contents($input_filename);
	
	//strip punctuations and characters
	$text = preg_replace("#[^\w']+#"," ",$text);
	
	//Strip numbers characters
	$text = strip_numbers( $text );
	
	//Convert to lower case
	$text = strtolower( $text);
	
	//Split the text into words
	$words = explode(" ", $text);
	
	//Stem the words using PorterStemmer algorithm
	$words_non_stemmed= array();
	foreach ( $words as $key => $word )
	{
		$stem = PorterStemmer::Stem( $word, true );
	    $words[$key] = $stem;
	    if (isset ($words_non_stemmed[$stem]))
	    {
	    	if (strlen($words_non_stemmed[$stem])>strlen($word))
	    	{
	    		$words_non_stemmed[$stem]=$word;
	    	}
	    }
	    else 
	    {
	    	$words_non_stemmed[$stem] = $word;
	    }
	}
	
	//print_r($words_non_stemmed);
	
	//Remove stop words
	$stopwords = explode("\n" ,file_get_contents($stopwords_filename));
	foreach ( $stopwords as $key => $word )
	{
	    $stopwords[$key] = PorterStemmer::Stem( $word, true );
	}
	
	$words = array_diff( $words, $stopwords );
	
	//Remove other unwanted words
	$bio_stopwords = explode("\n" ,file_get_contents($bio_stopwords_filename));
	
	foreach ( $bio_stopwords as $key => $word )
	{
	    $bio_stopwords[$key] = PorterStemmer::Stem( $word, true );
	}
	 
	$words = array_diff( $words, $bio_stopwords );
	
	//Remove the name of the author
	$authors = array(PorterStemmer::Stem( $author, true ));
	 
	$words = array_diff( $words, $authors);
	
	//*
	//Replace the stemwords by the word of the shortest length for better readibility
	foreach ($words as $key => $word)
	{
		$words[$key] = $words_non_stemmed[$word];
	}
	//*/
	//Count Keyword usage
	$keywordCounts = array_count_values( $words );
	
	arsort( $keywordCounts, SORT_NUMERIC );
	
	//print_r($keywordCounts);
	
	return $keywordCounts;
}

?>