<?php
require "config.php";
\Fr\LS::init();
if(!isset($_GET['username']))
{
	header("location: /userhome.php");
}
else
{
	$username = $_GET['username'];
	$query = \Fr\LS::$dbh->prepare("SELECT id,name FROM users WHERE username = '".$username."'");
	$query->execute();
	$ar = $query->fetch();
	$idUser = $ar['id'];
	$nome = $ar['name'];
	$email = $ar['email'];
	
	
	if($query->rowCount()!=1 or $idUser==Fr\LS::getUser("id"))
		header("location: /userhome.php");
	else
	{
		if(isset($_POST['send']))
		{
			$query = \Fr\LS::$dbh->prepare("SELECT tempo FROM conversazioni WHERE userid1 IN ('".$idUser."', '".Fr\LS::getUser("id")."') AND userid1 IN ('".$idUser."', '".Fr\LS::getUser("id")."') ORDER BY tempo DESC");
			$query->execute();
			
			//L'invio della mail è da testare
			if($query->rowCount()==0)
				\Fr\LS::sendMail($email, "Scambidilibri - Nuovo messaggio", "Ti e' arrivato un nuovo messaggio da ".Fr\LS::getUser("name")." (".Fr\LS::getUser("username")."<br> Vai su <a href='www.scambidilibri.tk'>scambidilibri.tk</a> per vedere il messaggio");
			else
			{
				$result = $query->fetch();
				if(time()-$result['tempo']>24*60*60)
					\Fr\LS::sendMail($email, "Scambidilibri - Nuovo messaggio", "Ti e' arrivato un nuovo messaggio da ".Fr\LS::getUser("name")." (".Fr\LS::getUser("username")."<br> Vai su <a href='www.scambidilibri.tk'>scambidilibri.tk</a> per vedere il messaggio");
			}
				
			
			$query = \Fr\LS::$dbh->prepare("INSERT INTO conversazioni VALUES (NULL, '".Fr\LS::getUser("id")."', '".$idUser."', '".$_POST['messaggio']."', '".time()."')");
			$query->execute();
		}
		?>
		<html>
			<head>
				<title>Scambidilibri - Chat con <? print $nome." (".$username.")";?></title>
			</head>
			<body>
				<a href="userhome.php">Torna</a> <br>
				<table border=1>
				<tr>
					<th><? print $username; ?></th>
					<th><? print Fr\LS::getUser("username");?></th>
				</tr>
				<?
				$query = \Fr\LS::$dbh->prepare("SELECT * FROM conversazioni WHERE userid1 IN ('".$idUser."', '".Fr\LS::getUser("id")."') AND userid2 IN ('".$idUser."', '".Fr\LS::getUser("id")."') ORDER BY tempo");
				$query->execute();
				while($result = $query->fetch())
				{
					print "<tr>";
					if($result['userid1']==$idUser)
						print "<td>".$result['messaggio']."</td><td></td>";
					else
						print "<td></td><td>".$result['messaggio']."</td>";
					
					print "<tr>";
				}
				?>
				</table>
				<meta http-equiv="refresh" content=30;URL='/chat.php?username=<? print $username; ?>'>
				<a href='/chat.php?username=<? print $username; ?>'>Aggiorna</a> <br><? // Va trovato un modo per aggiornare la pagina senza tornare all'inizio ?>
				<form method="post">
					<textarea name="messaggio" cols"100" rows="5"></textarea>
					<button name="send">Invia</button>
				</form>
				
			</body>
		</html>
		<?
	}
}
?>
