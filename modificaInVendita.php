<?php
require "config.php";
\Fr\LS::init();

if(!isset($_POST['modifica']) and !isset($_POST['elimina']))
	header("location: /userhome.php");
{
	$casa = $_POST['casa'];
	$autore = $_POST['autore'];
	$titolo = $_POST['titolo'];
	$isbn = $_POST['isbn'];
	$anno = (int) $_POST['anno'];
	$statoConservazione = (int) $_POST['conservazione'];
	$minPrezzo = (int)($_POST['minPrezzo']);
	$bloccato = $_POST['bloccato'];
	$idLibro = $_POST['idLibro'];
	if($_POST['elimina'])
	{
		$query = \Fr\LS::$dbh->prepare("DELETE FROM invendita WHERE libriid='".$idLibro."'");
		$query->execute();
		$query = \Fr\LS::$dbh->prepare("DELETE FROM libri WHERE id='".$idLibro."'");
		$query->execute();
		header("location: /userhome.php?msg=Libro eliminato");
	}
	else if(($titolo=="" and $isbn=="") or $maxPrezzo=="")
	{
		header("location: /userhome.php?msg=Informazioni insufficienti");
	}
	else
	{
		$query = \Fr\LS::$dbh->prepare("UPDATE invendita SET statoConservazione='".$statoConservazione."', prezzoMinimo='".$minPrezzo."', bloccato='".$bloccato."' WHERE libriid='".$idLibro."'");
		$query->execute();
		$query = \Fr\LS::$dbh->prepare("UPDATE libri SET titolo='".$titolo."', autore='".$autore."', isbn='".$isbn."', casa='".$casa."', anno='".$anno."' WHERE id='".$idLibro."'");
		$query->execute();
		header("location: /userhome.php?msg=Modifica avvenuta");
	}
}
?>
