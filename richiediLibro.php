<?php
require "config.php";
require "libStr.php";
\Fr\LS::init();


?>

<html>
	<head>
		<title>Scambidilibri - Cerca libro in vendita</title>
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
					<li><a href="modificaDati.php" class="active waves-effect waves-light">Modifica dati</a></li>
					<li class="active"><a href="richiediLibro.php" class="waves-effect waves-light">Cerca libro</a></li>
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
		
		<div class="container">
			<h1 class="orange-text center">Richiedi un libro</h1>
			<form id="ricerca">
				<div class="row">
					<div class="col s12 l6">
						<div class="z-depth-3 card white">
							<div class="card-content scelta">
								<div class="card-title orange-text">Informazioni sul libro</div>
								<div class="input-field">
									<label for="title">Titolo</label>
									<input type="text" id="title" name="title" <? print "value='".$_POST['title']."'"; ?>>
								</div>
								<div class="input-field">
									<label for="author">Autore</label>
									<input type="text" id="author" name="author" <? print "value='".$_POST['author']."'"; ?>>
								</div>
								<div class="input-field">
									<label for="isbn">ISBN</label>
									<input type="text" id="isbn" name="isbn" <? print "value='".$_POST['isbn']."'"; ?>>
								</div>
								<div class="input-field">
									<label for="casa">Casa editrice</label>
									<input type="text" id="casa" name="casa" <? print "value='".$_POST['casa']."'"; ?>> 
								</div>
								<div class="input-field">
									<label for="year">Anno di pubblicazione</label>
									<input type="text" id="year" name="year" <? print "value='".$_POST['year']."'"; ?>> <br>
								</div>
							</div>
						</div>
					</div>
					<div class="col s12 l6">
						<div class="z-depth-3 card white">
							<div class="card-content scelta">
								<div class="card-title orange-text">Visualizzazione</div>
								<div id="cont-radio">
									<h6 class="orange-text light">Minimo stato di conservazione </h5>
									<p>
										<input type="radio" id="usurato" name="conservazione" value="0" <? if(!isset($_POST['search']) or $_POST['conservazione']==0) print "checked='checked'";?>> 
										<label for="usurato">Usurato</label>
									</p>
									<p>
										<input type="radio" id="usato" name="conservazione" value="1" <? if($_POST['conservazione']==1) print "checked='checked'";?>> 
										<label for="usato">Usato</label>
									</p>
									<p>
										<input type="radio" id="nuovo" name="conservazione" value="2" <? if($_POST['conservazione']==2) print "checked='checked'";?>> 
										<label for="nuovo">Nuovo</label>
									</p>
								</div>
								<div class="input-field">
									<label for="maxPrezzo">Massimo prezzo</label>
									<input type="text" id="maxPrezzo" name="maxPrezzo" <? if(isset($_POST['maxPrezzo'])) print "value='".$_POST['maxPrezzo']."'"; else print "value='100'"; ?>> <br>
								</div>
								<div>
									<label for="nRisultati">Numero di risultati </label>
									<input type="text" id="nRisultati" name="nRisultati" <? if(isset($_POST['nRisultati'])) print "value='".$_POST['nRisultati']."'"; else print "value='50'"; ?>> <br>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<p class="center">
						<button class="waves-effect waves-light btn orange"name="search">Cerca</button>
					</p>
				</div>
			</form>
			
		</div>
	
		<div id="result" style="margin-bottom:3em;">
		
		</div>
		
			
				
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/init.js"></script>
	</body>
</html>
