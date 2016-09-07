<?php
require "config.php";
\Fr\LS::init();
if(!isset($_GET['chiave']))
	header("location: /index.php");
else
{
	$chiave = $_GET['chiave'];
	$query = \Fr\LS::$dbh->prepare("SELECT * FROM changeMailTemp WHERE chiave = '".$chiave."'");
	$query->execute();
	if($query->rowCount()!=1)
		header("location: /index.php");
	else
	{
		$result = $query->fetch(PDO::FETCH_ASSOC);
		
		\Fr\LS::updateUser(array(
		"email"  => $result['newEmail'],
		));
		$query = \Fr\LS::$dbh->prepare("DELETE FROM changeMailTemp WHERE chiave = '".$chiave."'");
		$query->execute();
		?> <script>
		alert("La modifica della password e' andata a buon fine");
		window.location = "index.php"; 
		</script>
		<?
		
		
		
	}
}
?>
