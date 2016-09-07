
<?php
require "config.php";
\Fr\LS::init();

?>
<!doctype html> 
<html>
<head>
    
	
	<title>Scambidilibri - Pagina utente di <? print \Fr\LS::getUser("name");?></title>
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<meta charset="utf-8" /> 
</head>
<body>
<body>
	
	<nav class="orange lighten-1">
	<div class="nav-wrapper container">
	  <a id="logo-container" href="#" class="brand-logo">Scambi di libri</a>
	  <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
	  <ul class="right hide-on-med-and-down">
		<li><a href="modificaDati.php" class="waves-effect waves-light">Modifica dati</a></li>
		<li><a href="richiediLibro.php" class="waves-effect waves-light">Cerca libro</a></li>
		<li><a href="vendiLibro.php" class="waves-effect waves-light">Vendi libro</a></li>
		<li><a href="logout.php" class="waves-effect waves-light">Logout</a></li>
	  </ul>
	  <ul class="side-nav" id="mobile-demo">
		<li><a href="modificaDati.php" class="waves-effect waves-light">Modifica dati</a></li>
		<li><a href="richiediLibro.php" class="waves-effect waves-light">Cerca libro</a></li>
		<li><a href="vendiLibro.php" class="waves-effect waves-light">Vendi libro</a></li>
		<li><a href="logout.php" class="waves-effect waves-light">Logout</a></li>
	  </ul>
	</div>
	</nav>
	
	
	
	<!--Da formattare-->
	<div id="cont-tabella" class="white z-depth-4">
	<h4 class="orange-text center" style="margin-top:0px:">Libri richiesti</h4>
		<?
		$queryTxt = "SELECT * FROM libri,richiesto WHERE richiesto.libriid=libri.id AND richiesto.userid='".Fr\LS::getUser("id")."'";
		$query = \Fr\LS::$dbh->prepare($queryTxt);
		$query->execute();
		if($query->rowCount()==0)
		{
			print "<h6 class='orange-text center'>Nessun libro</h4>";
		}
		else{
			?>
			<table class="hoverable centered">
		<thead class="orange-text light">
			<th>Titolo</th>
			<th>Autore</th>
			<th>ISBN</th>
			<th>Casa editrice</th>
			<th>Anno di pubblicazione</th>
			<th>Minimo stato di conservazione</th>
			<th>Massimo prezzo</th>
			<th>Bloccato</th>
			<th></th>
		</thead>
			
			<?php
			while($result=$query->fetch())
			{
				print "<form action='modificaRichiesto.php' method='post'>";
				print "<tr>";
				print "<td><input type='text' name='titolo' value='".$result['title']."'></td>";
				print "<td><input type='text' name='autore' value='".$result['autore']."'></td>";
				print "<td><input type='text' name='isbn' value='".$result['isbn']."'></td>";
				print "<td><input type='text' name='casa' value='".$result['casa']."'></td>";
				print "<td><input type='text' name='anno' value='".$result['anno']."'></td>";
				print "<td>";
				?>
				<div id="cont-radio" style="text-align:left;">
				
							<input type="radio" id="usurato" name="conservazione" value="0" <? if($result['statoConservazioneMinimo']==0) print "checked='checked'";?>>
							<label for="usurato">Usurato</label>
					
							<input type="radio" id="usato" name="conservazione" value="1" <?if($result['statoConservazioneMinimo']==1) print "checked='checked'";?>>
							<label for="usato">Usato</label>
					
							<input type="radio" id="nuovo" name="conservazione" value="2" <?if($result['statoConservazioneMinimo']==2) print "checked='checked'";?>> 
							<label for="nuovo">Nuovo</label>
	
				</div>
					<?php
				print "</td>";
				print "<td><input type='text' name='maxPrezzo' value='".$result['prezzoMassimo']."'></td>";
				print "<td><input type='checkbox' name='bloccato' "; if($result['bloccato']==1) print "checked='checked'"; print "></td>"; // sistemare la checkbox
				print "<td><button type='submit' name='modifica' class='btn orange waves-effect waves-light' value='Elimina'>Modifica</button><br/><br/>";
				print "<button type='submit' name='elimina' class='btn orange waves-effect waves-light' value='Elimina'>Elimina</button></td>";
				print "<input type='hidden'  name='idLibro' value='".$result['libriid']."'>";
				print "</tr>";
				print "</form>";
			}
		}
		?>
	</table>
	</div>
	
	Libri messi in vendita:
	<!-- Da formattare similmente ai richiesti -->
	
	Chat attive: <br>
	<?
	$queryTxt = "SELECT * FROM conversazioni,users WHERE (conversazioni.userid1='".Fr\LS::getUser("id")."' AND conversazioni.userid2=users.id) OR (conversazioni.userid2='".Fr\LS::getUser("id")."' AND conversazioni.userid1=users.id) ORDER BY tempo DESC";
	$query = \Fr\LS::$dbh->prepare($queryTxt);
	$query->execute();
	while($risultato=$query->fetch())
	{
		if($toccato[$risultato['username']]!==1)
			print "<a href=chat.php?username=".$risultato['username'].">".$risultato['username']."</a><br>";
		$toccato[$risultato['username']]=1;
	}
	?>
	
	<!--Fine parte da formattare-->
	
		
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/init.js"></script>
</body>
</html>


