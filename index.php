<?php
require "config.php";
\Fr\LS::init();
if(isset($_POST['login'])){
	$identification = $_POST['login'];
	$password = $_POST['pass'];
	if($identification == "" || $password == ""){
		{
		$msg = "Errore: Username / Password errati !";
	}
	}else{
    $login = \Fr\LS::login($identification, $password, isset($_POST['remember_me']));
		if($login === false){
			$msg = "Errore: Username / Password errati !";
		}else if(is_array($login) && $login['status'] == "blocked"){
			$msg = "Errore: troppi tentativi. Prova tra ". $login['minutes'] ." minuti (". $login['seconds'] ." secondi)";
		}
	}
	
	//print $msg."<br>";
}
?>
<!doctype html> 
<html>
<head>
	<title>Scambidilibri - Home page</title>
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	 <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	 <meta charset="utf-8" /> 
</head>
<body>
	<?if(isset($msg))
	{
		?>
	<script language="javascript">
	Materialize.toast('<? print $msg; ?>', 4000);
	</script>
	<? } ?>
	<nav class="orange lighten-1" role="navigation">
		<div class="nav-wrapper container">
			<a id="logo-container" href="#" class="brand-logo">Scambi di libri</a>
		</div>
	</nav>
	
	<div class="section no-pad-bot" id="index-banner">
		<div class="container">
			<br><br>
			<h1 class="header center orange-text">Scambi di libri</h1>
			<div class="row center">
				<h5 class="header col s12 light">Il primo sito per scambiare libri in Trentino</h5>
			</div>
			<br><br>
		</div>
	</div>
	
	<div class="container">
		<div class="section">
			<div class="row">
				<div class="col s12 l7 z-depth-3 orange" id="intest">
					<b>Benvenuto su scambidilibri.tk!</b>
				</div>
				<form method="POST">
					<div class="col s12  offset-l1 l4">
						<div class="z-depth-3 card white">
							 <div class="card-content">
								
							    <div class="input-field">
									<i class="mdi-action-account-circle prefix"></i>
									<input name="login" id="login" type="text"/>
									<label for="login">Username / E-Mail</label>
								</div>
								<div class="input-field">
									<i class="mdi-communication-vpn-key prefix"></i>
									<input name="pass" id="pass" type="password"/>
									<label for="pass" >Password</label>
								</div>
								<div>
									<input type="checkbox" name="remember_me" id="remember_me"/> 
									<label for="remember_me">Ricordami</label>
								</div>
								
							</div>
							<div class="card-action">
								<span class="row">
									<span class="col s6">
										<button name="act_login"  class="modal-action waves-effect waves-light btn orange">Login</button>
									</span>
									<span class="col s6">
										<a style="padding-left:1em;" href="register.php"> Registrati </a>
									</span>
								</span>
								<span class="row">
									<a style="padding-left:1em;" href="forgotPassword.php" class="right">Password dimenticata</a>
								</span>
							</div>
						</div>
						
					</div>
				</form>
				
			</div>
		</div>
	</div>
		
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
	</body>
</html>
