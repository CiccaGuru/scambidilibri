<?php
require "config.php";
\Fr\LS::init();

$campiOK = TRUE;
if(isset($_POST['username']) || isset($_POST['name']) || isset($_POST['email'])/* || isset($_POST['password']) || isset($_POST['password2'])*/){
	$username = $_POST['username'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	//$password = $_POST['password'];
	
	// pulisci la tabella registrationTemp
	$query = \Fr\LS::$dbh->prepare("DELETE FROM registrationTemp WHERE tempo < ".time()-3600);
	
	
	$query = \Fr\LS::$dbh->prepare("SELECT * FROM registrationTemp WHERE username = '".$username."'");
	$query->execute();
	$query2 = \Fr\LS::$dbh->prepare("SELECT * FROM users WHERE username = '".$username."'");
	$query2->execute();
	
	print '<html><head><script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="http://scambidilibri.tk/js/materialize.min.js"></script>
    <script type="text/javascript" src="http://scambidilibri.tk/js/init.js"></script>
    <link type="text/css" rel="stylesheet" href="http://scambidilibri.tk/css/materialize.min.css"  media="screen,projection"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<link href="http://scambidilibri.tk/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<meta charset="utf-8" />     
    </head><body>';
	
	if($username=="" or ($query->rowCount() + $query2->rowCount())>0)
	{
		//print("L'username ".$username." non e' valido o e' stato gia' usato. Inseriscine un altro.<br>");
		
		print '<script language="javascript">
	Materialize.toast("L`username "'.$username.'" non e` valido", 4000);
	</script>';
		$campiOK=FALSE;
	}
	if($name=="")
	{
		print '<script language="javascript">
	Materialize.toast("Il nominativo "'.$name.'" non e` valido", 4000);
	</script>';
		$campiOK=FALSE;
	}
	
	$query = \Fr\LS::$dbh->prepare("SELECT * FROM registrationTemp WHERE email = '".$email."'");
	$query->execute();
	$query2 = \Fr\LS::$dbh->prepare("SELECT * FROM users WHERE email = '".$email."'");
	$query2->execute();
	
	if($email=="" or $query->rowCount() + $query2->rowCount()>0 or !\Fr\LS::validEmail($email))
	{
		//print("La email ".$email." non e' valida o e' stata gia' usata. Inseriscine un'altra.<br>");
		print '<script language="javascript">
		Materialize.toast("La mail "'.$email.'" non e` valida o e` stata gia` usata", 4000);
		</script>';
		$campiOK=FALSE;
	}
	
	print "</body></html>";
	
	/*if($password=="" || $_POST['password2']!=$password)
	{
		print("La password non e' valida.<br>");
		$campiOK=FALSE;
	}*/
	if($campiOK)
	{
		do
		{
			$chiave = \Fr\LS::rand_string(10);
			$query = \Fr\LS::$dbh->prepare("SELECT * FROM registrationTemp WHERE chiave = '".$chiave."'");
			$query->execute();
		}
		while($query->rowCount()>0);
		$query = \Fr\LS::$dbh->prepare("INSERT INTO registrationTemp VALUES (NULL, '".$username."', '".$email."', '".$name."', '".$chiave."', '".time()."')");
		$query->execute();
		
		\Fr\LS::sendMail($email, "Iscrizione a scambidilibri", "Per iscriverti a scambidilibri fai click sul seguente link: <br> <a href='www.scambidilibri.tk/confirm.php?chiave=".$chiave."'>www.scambidilibri.tk/confirm.php?chiave=".$chiave."</a>");
		header("location: /index.php?msg=Controlla la tua mail entro un'ora");
	}
}
?>

<html>
	<head>
		<title>Scambidilibri - Registrazione</title>
	</head>
	<body>
		<div class="content">
			<form method="POST">
				<label>Nominativo</label><br/>
				<input name="name" type="text" value="<? if(!$campiOK) print $name;?>"/><br/>
				<label>Username</label><br/>
				<input name="username" type="text" value="<? if(!$campiOK) print $username;?>"/><br/>
				<label>Email</label><br/>
				<input name="email" type="text" value="<? if(!$campiOK) print $email;?>"/><br/>
				<button name="act_reg">Registrati</button>
			</form>
			<br>
			<a href="index.php"> Home Page </a>
		</div>
	</body>
</html>
