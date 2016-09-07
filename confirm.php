<?php
require "config.php";
\Fr\LS::init();
if(!isset($_GET['chiave']))
	header("location: /index.php");
else
{
	$chiave = $_GET['chiave'];
	$query = \Fr\LS::$dbh->prepare("SELECT * FROM registrationTemp WHERE chiave = '".$chiave."'");
	$query->execute();
	if($query->rowCount()!=1)
		header("location: /index.php");
	else
	{

		$result = $query->fetch(PDO::FETCH_ASSOC);
		
		if(isset($_POST['password']) and isset($_POST['password2']) and $_POST['password']===$_POST['password2'] and $_POST['password']!="")
		{
			\Fr\LS::register($result['username'], $_POST['password'], array("email" => $result['email'], "name" => $result['name']));
			$query = \Fr\LS::$dbh->prepare("DELETE FROM registrationTemp WHERE chiave = '".$chiave."'");
			$query->execute();
			?> <script>
			alert("La registrazione e' andata a buon fine");
			window.location = "index.php"; 
			</script>
			<?
		}
		else
		{
			?>
			<html>
			<head>
				<title>Scambidilibri - Conferma Registrazione</title>
			</head>
			<body>
				<div class="content">
					<?
					if(isset($_POST['password']) or isset($_POST['password2']))
						print "Le password non sono valide o non corrispondono<br>";
					?>
					Nominativo: <? print $result['name']; ?> <br>
					Username: <? print $result['username']; ?> <br>
					Email: <? print $result['email']; ?> <br>
					
					<form method="POST">
						<label>Password</label><br/>
						<input name="password" type="password"/><br/>
						<label>Ripeti password</label><br/>
						<input name="password2" type="password"/><br/>
						<button name="act_reg">Invia</button>
					</form>
					<br>
					<a href="index.php"> Home Page </a>
				</div>
			</body>
			</html>
			<?
		}
		
		
	}
}
?>
