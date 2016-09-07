<?php
require "config.php";
\Fr\LS::init();

if(!isset($_REQUEST['conservazione']) or $_REQUEST['conservazione']=="")
	header("location: /userhome.php");
{
	$casa = $_REQUEST['casa'];
	$autore = $_REQUEST['author'];
	$titolo = $_REQUEST['title'];
	$isbn = $_REQUEST['isbn'];
	$anno = (int) $_REQUEST['year'];
	$statoConservazione = (int) $_REQUEST['conservazione'];
	$minPrezzo = (int)($_REQUEST['minPrezzo']);
	if(($titolo=="" and $isbn=="") or $minPrezzo=="")
	{
		header("location: /richiediLibro.php?msg=Informazioni insufficienti");
	}
	else
	{
		$query = \Fr\LS::$dbh->prepare("INSERT INTO libri VALUES (NULL, '".$titolo."', '".$autore."', '".$isbn."', '".$casa."', '".$anno."')");
		$query->execute();
		//print "INSERT INTO richiesto VALUES (NULL, '".\Fr\LS::getUser('id')."', '".\Fr\LS::$dbh->lastInsertId()."', '".$statoConservazione."', '".$maxPrezzo."', '0');";
		$query = \Fr\LS::$dbh->prepare("INSERT INTO invendita VALUES (NULL, '".\Fr\LS::getUser('id')."', '".\Fr\LS::$dbh->lastInsertId()."', '".$statoConservazione."', '".$minPrezzo."', '0');");
		$query->execute();
		header("location: /userhome.php?msg=Inserimento avvenuto");
	}
}
?>

