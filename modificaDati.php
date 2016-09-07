<?php
require "config.php";
\Fr\LS::init();

if(isset($_POST['mod_name']))
{
	$name = $_POST['name'];
	if($name=="")
	{
		print("Il nominativo non e' valido. Inseriscine un altro.<br>");
	}
	else
	{
		\Fr\LS::updateUser(array("name"=>$name));
	}
} elseif(isset($_POST['mod_pass']))
{
	$password = $_POST['pass'];
	$password2 = $_POST['pass2'];
	if($password!==$password2 or $password==="")
		print "Le password non sono valide o non corrispondono<br>";
	else
		\Fr\LS::changePassword("", $password);
} elseif(isset($_POST['mod_email']))
{
	$email = $_POST['email'];
	$query2 = \Fr\LS::$dbh->prepare("SELECT * FROM users WHERE email = '".$email."'");
	$query2->execute();
	
	if($email=="" or /*$query->rowCount() +*/ $query2->rowCount()>0 or !\Fr\LS::validEmail($email))
	{
		print("La email ".$email." non e' valida o e' stata gia' usata. Inseriscine un'altra.<br>");
		$campiOK=FALSE;
	}
	else
	{
		do
		{
			$chiave = \Fr\LS::rand_string(10);
			$query = \Fr\LS::$dbh->prepare("SELECT * FROM changeMailTemp WHERE chiave = '".$chiave."'");
			$query->execute();
		} while($query->rowCount()>0);
		
		$query = \Fr\LS::$dbh->prepare("INSERT INTO changeMailTemp VALUES (NULL, '".$email."', '".Fr\LS::getUser("id")."', '".$chiave."')");
		$query->execute();
		\Fr\LS::sendMail($email, "Cambio mail - scambidilibri", "Per cambiare la tua mail di scambidilibri, accedi al sito col tuo account e poi fai click sul seguente link: <br> <a href='www.scambidilibri.tk/confirm2.php?chiave=".$chiave."'>www.scambidilibri.tk/confirm2.php?chiave=".$chiave."</a>");
		?> <script>
		alert("Controlla la tua mail");
		window.location = "userhome.php"; 
		</script>
		<?
	}
}

?>
<html>
	<head>
		<title>Scambidilibri - Modifica dati</title>
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
		<meta charset="utf-8" /> 
	</head>
	<body>
		
		<nav class="orange lighten-1">
			<div class="nav-wrapper container">
				<a id="logo-container" href="#" class="brand-logo">Scambi di libri</a>
				<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
				<ul class="right hide-on-med-and-down">
					<li><a href="userhome.php" class="waves-effect waves-light">Home</a></li>
					<li  class="active"><a href="modificaDati.php" class="active waves-effect waves-light">Modifica dati</a></li>
					<li><a href="richiediLibro.php" class="waves-effect waves-light">Cerca libro</a></li>
					<li><a href="vendiLibro.php" class="waves-effect waves-light">Vendi libro</a></li>
					<li><a href="logout.php" class="waves-effect waves-light">Logout</a></li>
				</ul>
				<ul class="side-nav" id="mobile-demo">
					<li><a href="userhome.php" class="waves-effect waves-light">Home</a></li>
					<li class="active"><a href="modificaDati.php" class="waves-effect waves-light">Modifica dati</a></li>
					<li><a href="richiediLibro.php" class="waves-effect waves-light">Cerca libro</a></li>
					<li><a href="vendiLibro.php" class="waves-effect waves-light">Vendi libro</a></li>
					<li><a href="logout.php" class="waves-effect waves-light">Logout</a></li>
				</ul>
			</div>
		</nav>
		
		<div class="container" id="conten">
		
		<div class="row">
			<div class="col l6 s12">
					<form method="POST">
						<div class="z-depth-3 card white">
							<div class="card-content">
								<span class="card-title orange-text">Modifica nome</span>
								<div class="input-field">
									<i class="mdi-action-account-circle prefix"></i>
									<input name="name" type="text" value="<? print Fr\LS::getUser("name");?>"/>
									<label for="name">Nome</label>
								</div>
							</div>
							<div class="card-action">
								<button name="mod_name" class="waves-effect waves-light btn orange">Modifica nome</button>
							</div>
						</div>
					</form>
					<form method="POST">
						<div class="z-depth-3 card white">
							<div class="card-content">
								<span class="card-title orange-text">Modifica email</span>
								<div class="input-field">
									<i class="mdi-content-mail prefix"></i>
									<input name="email" type="text" value="<? print Fr\LS::getUser("email");?>"/>
									<label for="email">Email</label>
								</div>
							</div>
							<div class="card-action">
								<button  name="mod_email" class="waves-effect waves-light btn orange">Modifica email</button>
							</div>
						</div>
					</form>
			</div>
			<div class="col s12 l6">
				<form method="POST">
						<div class="z-depth-3 card white">
							<div class="card-content">
								<span class="card-title orange-text">Modifica password</span>
								<div class="input-field">
									<i class="mdi-communication-vpn-key prefix"></i>
									<input name="pass" type="password"/>
									<label for="pass">Nuova password</label>
								</div>
								<div class="input-field">
									<i class="mdi-communication-vpn-key prefix active"></i>
									<input name="pass2" type="password" />
									<label for="pass2">Ripeti password</label>
								</div>
							</div>
							<div class="card-action">
								<button  name="mod_pass" class="waves-effect waves-light btn orange">Modifica password</button>
							</div>
						</div>
					</form>
			</div>
		</div>
		</div>
		
		
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/init.js"></script>
	</body>
</html>

