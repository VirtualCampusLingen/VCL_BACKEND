<?php

/**
 * Basisverzeichnis ohne abschliessendem Slash
 */
$DOCUMENT_ROOT = dirname(__FILE__);

// Zugangsdaten für MySQL
$MYSQL_host = 'localhost';
$MYSQL_user = '...';
$MYSQL_passw = '...';
$db = '...';

/**
 * Datenbankverbindung herstellen
 */
$tools_dir = $DOCUMENT_ROOT . "/tools/";
include_once($tools_dir . "connect.php");
include_once($tools_dir . "sql.php");
$dblk = connect($MYSQL_host, $MYSQL_user, $MYSQL_passw, $db);

$error = 0;

if(!empty($_POST['mail_1']) && !empty($_POST['mail_2'])){
	//Mail gleich
	if($_POST['mail_1']==$_POST['mail_2']){
		//Update in der Datenbank
		sql("UPDATE `admin` SET `E_MAIL` = '". mysql_real_escape_string($_POST['mail_1'])."' WHERE `AdminID` = 1");
		$mail_admin = $_POST['mail_1'];
	}
	else{
		$error = 1;
	}
}
elseif((empty($_POST['mail_1'])||empty($_POST['mail_2']))|| $error = 1){

/**
 * Email vom Admin
 */
$result = sql("SELECT `E_Mail` FROM `admin`");
$mail_admin = mysql_fetch_assoc($result);
$mail_admin = $mail_admin['E_Mail'];

}
printf($error);

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html">VCL</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.html">Home</a></li>
			<li class="active" class="dropdown">
				<a href="edit_admin.php" class="dropdown-toggle" data-toggle="dropdown">Administration <b class="caret"></b></a>
				 <ul class="dropdown-menu">
					<li><a href="edit_admin_pw.php">Passwort ändern</a></li>
					<li class="active"><a href="edit_admin_mail.php">Email ändern</a></li>
              </ul>	
			</li>
            <li><a href="edit_infotext.php">Infotexte</a></li>
			<li><a href="edit_picture.php">Fotos</a></li>
			<li><a href="edit_map.php">Übersichtskarte</a></li>
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <div class="jumbotron" style="padding: 10px 0px 10px 0px;">
      <div class="container">
		<h1 style="color:red;">Datenbankabfragen noch nicht ok</h1>
		<h2>Email des Administrators ändern - zurzeit "<?=$mail_admin?>"</h2>
      </div>
    </div>

    <div class="container">
		<div>
		
		<form class="navbar-form pull-left" method="POST">  
		  <b>Neues Email:</b><br/>
		  <input type="text" class="" name="mail_1" placeholder="Email...">
		  <br/>
		  <br/>
		  <b>Neues Email bestätigen:</b><br/>  
		  <input type="text" class="" name="mail_2"placeholder="Email...">
		  <br/>  
		  <br/>
		  <button type="submit" class="btn">Ändern</button>  
		</form>
		<br style="clear:both;"/>
		</div>

      <hr>

      <footer>
        <p>&copy; VCL 2013</p>
      </footer>
    </div> <!-- /container -->        
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/main.js"></script>

        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>
