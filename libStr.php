<?php

function wordsDistance($source, $final)
{
	$source = strtolower($source);
	$final = strtolower($final);
	$costoElimina = 1;
	$costoInserisci = 1;
	$costoScambia = 1;
	$Lsource = strlen($source);
	$Lfinal = strlen($final);
	
	for($i=0; $i<=$Lsource; $i++)
		$dist[$i][0]=$costoElimina*$i;
	for($i=0; $i<=$Lfinal; $i++)
		$dist[0][$i]=$costoInserisci*$i;
	for($i=1; $i<=$Lsource; $i++)
		for($j=1; $j<=$Lfinal; $j++)
			$dist[$i][$j]=min($dist[$i-1][$j-1]+$costoScambia, $dist[$i-1][$j]+$costoElimina, $dist[$i][$j-1]+$costoInserisci);
	return $dist[$Lsource][$Lfinal];
}

function sentencesDistance($keywords, $sentence)
{
	
	$keywordsAr = explode(" ", $keywords);
	$sentenceAr = explode(" ", $sentence);
	if(count($keywordsAr)*count($sentenceAr)==0)
		return 1000;
	$ris = 0;
	foreach($keywordsAr as $a)
		foreach($sentenceAr as $b)
			$ris+=wordsDistance($a,$b);
	$ris/=count($keywordsAr)*count($sentenceAr);
	return $ris;
}

?>
