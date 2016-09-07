<?php
require "config.php";
require "libStr.php";
\Fr\LS::init();

?>
<div id="cont-tabella" class="white z-depth-4">
<?
	if(isset($_POST['search']))
			{
				?>
				<table class="hoverable centered">
					<thead class="orange-text light">
						<th>Titolo</th>
						<th>Autore</th>
						<th>ISBN</th>
						<th>Casa editrice</th>
						<th>Anno di pubblicazione</th>
						<th>Stato di conservazione</th>
						<th>Minimo prezzo richiesto</th>
						<th>Contatta il venditore</th>
					</thead>
				<?
				$casa = $_POST['casa'];
				$autore = $_POST['author'];
				$titolo = $_POST['title'];
				$isbn = $_POST['isbn'];
				$anno = (int) $_POST['year'];
				$statoConservazione = (int) $_POST['conservazione'];
				$maxPrezzo = (int)($_POST['maxPrezzo']);
				$queryTxt = "SELECT * FROM libri,invendita,users WHERE invendita.bloccato=0 AND libri.id=invendita.libriid AND users.id=invendita.userid AND invendita.statoConservazione>=".$statoConservazione." AND (invendita.prezzoMinimo<=".$maxPrezzo." OR invendita.prezzoMinimo IS NULL)";
				if(strlen($isbn)==13)
					$queryTxt = $queryTxt." AND libri.isbn=".$isbn." OR libri.isbn IS NULL)";
				if($anno>0)
					$queryTxt = $queryTxt." AND (libri.anno=".$anno." OR libri.anno IS NULL)";
				
				$query = \Fr\LS::$dbh->prepare($queryTxt);
				$query->execute();
				$vettoreLibri = $query->fetchAll();
				$vettoreMatching = array();
				foreach($vettoreLibri as $el)
				{
					$vettoreMatching[] = sentencesDistance($titolo,$el['titolo']);
				}
				array_multisort($vettoreMatching, $vettoreLibri);
				for($i=0; $i<$_POST['nRisultati'] && $i<count($vettoreLibri); $i++)
				{
					echo "<tr>";
					$el = $vettoreLibri[$i];
					echo "<td>".$el['titolo']."</td>";
					echo "<td>".$el['autore']."</td>";
					echo "<td>".$el['isbn']."</td>";
					echo "<td>".$el['casa']."</td>";
					echo "<td>".$el['anno']."</td>";
					echo "<td>";
					switch($el['statoConservazione'])
					{
						case "0":
						echo "Usurato";
						break;
						case "1":
						echo "Usato";
						break;
						case "2":
						echo "Nuovo";
						break;
					}
					echo "</td>";
					echo "<td>".$el['prezzoMinimo']."€</td>";
					//echo "<td><form method='get' action='chat.php'><input type='hidden' value='".$el['username']."' name='username'><button class=\"waves-effect waves-light btn orange\"  type='submit'>".$el['username']."</button></form></td>";
					echo "<td><a href='chat.php?username=".$el['username']."' class='btn waves-effect waves-light orange'>".$el['username']."</a></td>";
					echo "</tr>";
				}
				?>
			
				</table>
			</div>
				<? // mostrare ulteriori risultati
				
				if(($titolo!="" or $isbn!="") and $maxPrezzo!="")
				{
					echo ' 
					<div class="center">
						<a href="inserisciRichiesto.php
						?casa='.$casa.'
						&author='.$autore.'
						&title='.$titolo.'
						&isbn='.$isbn.'
						&conservazione='.$conservazione.'
						&maxPrezzo='.$maxPrezzo.'
						" class="btn waves-effect waves-light orange">Richiedi libro</a>
					</div>
					';
				}
			}
			?>
		</div>
	</div>
