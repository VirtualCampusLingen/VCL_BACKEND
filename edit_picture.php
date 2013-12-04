<?php
//Upload PHP

$DOCUMENT_ROOT = dirname(__FILE__);

$tools_dir = $DOCUMENT_ROOT . "/tools/";
include_once($tools_dir . "connect.php");
include_once($tools_dir . "sql.php");
$dblk = connect();

if(isset($_POST['Upload'])){

  if ($_FILES['fileToUpload']['error'] > 0) {
      echo "Error: " . $_FILES['fileToUpload']['error'] . "<br />";
  } else {
      // array of valid extensions
      $validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
      // get extension of the uploaded file
      $fileExtension = strrchr($_FILES['fileToUpload']['name'], ".");
      // check if file Extension is on the list of allowed ones
      if (in_array($fileExtension, $validExtensions)) {
          // we are renaming the file so we can upload files with the same name
          $newName = $_FILES['fileToUpload']['name'];
          $destination = 'assets/img_360/' . $newName;
          $description = mysql_real_escape_string($_POST['description']);
	   $photo_name = mysql_real_escape_string($_POST['photo_name']);
          if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $destination)) {
            chmod($destination,0644);
              echo 'File ' .$newName. ' succesfully copied';

              sql("INSERT INTO `db_vcl`.`photo` (`photo_name`, `description`, `path`, `uploaded_at`, `x_position`, `y_position`, `map_id`) 
                   VALUES ('".$photo_name."', '".$description."', '".$destination."', '".date('Y-m-j')."', NULL, NULL, NULL)");
          }
      } else {
          echo 'Bitte wählen Sie ein Bild! (.jpg, .jpeg, .gif, .png)';
      }
  }
}

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
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="assets/css/main.css">

        <script src="assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
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
 <a class="navbar-brand" href="index.html"><img src="assets/img/Logo.png" width="37" height="20" alt="home"/></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.html">Home</a></li>
			<li class="dropdown">
				<a href="edit_admin.php" class="dropdown-toggle" data-toggle="dropdown">Administration <b class="caret"></b></a>
				 <ul class="dropdown-menu">
					<li><a href="edit_admin_pw.php">Passwort ändern</a></li>
					<li><a href="edit_admin_mail.php">Email ändern</a></li>
              </ul>	
			</li>
            <li><a href="edit_infotext.php">Infotexte</a></li>
			<li class="active"><a href="edit_picture.php">Fotos</a></li>
			<li class="dropdown">
        <a href="edit_admin.php" class="dropdown-toggle" data-toggle="dropdown">Übersichtskarten <b class="caret"></b></a>
         <ul class="dropdown-menu">
          <li><a href="edit_map.php?map_id=1">Halle 1/2</a></li>
          <li><a href="edit_map.php?map_id=2">KE</a></li>
              </ul> 
      </li>
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron" style="padding: 10px 0px 10px 0px;">
      <div class="container">
		  <h2>Hochladen & Verwalten von Fotos</h2>
      </div>
    </div>

    <div class="container">
      
        <form enctype="multipart/form-data" method="post">
          <div class="row">
            <label for="fileToUpload">File to Upload</label><br />
            <input type="file" name="fileToUpload" id="fileToUpload" /><br/><br/>
            <label for="description">Description</label><br/>
            <input type="text" name="description" /><br/><br/>
            <label for="photo_name">Photoname</label><br/>
            <input type="text" name="photo_name" /><br/><br/>
          </div>
          <div class="row">
            <input type="submit" value="Upload" name="Upload"/>
          </div>
        </form>

      <hr>

      <footer>
        <p>&copy; VCL 2013</p>
      </footer>
    </div> <!-- /container -->        
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-1.10.1.min.js"><\/script>')</script>

        <script src="assets/js/vendor/bootstrap.min.js"></script>

        <script src="assets/js/main.js"></script>

        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>
