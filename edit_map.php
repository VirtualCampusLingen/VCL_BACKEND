<?php
$DOCUMENT_ROOT = dirname(__FILE__);

$tools_dir = $DOCUMENT_ROOT . "/tools/";
include_once($tools_dir . "connect.php");
include_once($tools_dir . "sql.php");
$dblk = connect();

$error = 0;

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
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/css/edit_map.css">

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
          <a class="navbar-brand" href="index.html">VCL</a>
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
      <li><a href="edit_picture.php">Fotos</a></li>
      <li class="active"><a href="edit_map.php">Übersichtskarte</a></li>
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron" style="padding: 10px 0px 10px 0px;">
      <div class="container">
    <h2>Platziere ein neues Bild auf der Übersichtskarte</h2>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <script src="assets/js/vendor/jquery-1.10.1.min.js"></script>
      <script src="assets/js/main.js"></script>
      <script src="assets/js/vendor/bootstrap.min.js"></script>
      <script src="assets/js/bootstrap-select.min.js"></script>
      

      <?php 
        //Read GET Data
        $mapId = $_GET['map_id'] || 1;
        //Read transmitted POST Data
        $id = $_POST['ID'];
        $xPos = $_POST['x_position'];
        $yPos = $_POST['y_position'];
        if(!empty($xPos)){
          sql("UPDATE photo SET 
            map_id = '1',
            x_position='" .$xPos. "', 
            y_position='" .$yPos. "' 
            WHERE ID='" .$id. "' ");
        }
      ?>

      <?php
        $sql_photo = sql("SELECT * FROM photo WHERE map_id='" .$mapId. "'");
        $sql_map_path = sql("SELECT path FROM map WHERE ID='" .$mapId. "'");
        $hsh = [];
        $i = 0;
        while($row = mysql_fetch_assoc($sql_photo)){
          $hsh[$i] = [];
          $hsh[$i]["ID"] = $row["ID"];
          $hsh[$i]["photo_name"] = $row["photo_name"];
          $hsh[$i]["description"] = $row["description"];
          $hsh[$i]["x_position"] = $row["x_position"];
          $hsh[$i]["y_position"] = $row["y_position"];
          $hsh[$i]["map_id"] = $row["map_id"];

          if($hsh[$i]["x_position"] && $hsh[$i]["y_position"]){
            echo("<img id='dot0' 
              class='map_dots' 
              src='assets/img/dot.png' 
              data-x-pos='" . $hsh[$i]["x_position"] . "' 
              data-y-pos='".$hsh[$i]["y_position"]."'
              data-original-title=''
              title = '" . $hsh[$i]["photo_name"] . "'
              data-content= '" . $hsh[$i]["description"] . "'
              <a onclick='$(this).popover()'></a>
              />");
          }
          $i++;
        }
      ?>

      <script>        
        $(window).load(function(){
          $("#photo_pick").selectpicker();

          imgOffset = $("#uebersichts_map").offset();
          $("#uebersichts_map_area").click(function(e){
            $("#uebersichts_map_X").val(e.pageX-imgOffset.left);
            $("#uebersichts_map_Y").val(e.pageY-imgOffset.top);
          });

          $(".map_dots").each(function(){
            $(this).popover();

            var map_dot = $(this);
            var offsetTop = imgOffset.top + parseInt(map_dot.attr("data-y-pos")) - map_dot.height()/2;
            var offsetLeft = imgOffset.left + parseInt(map_dot.attr("data-x-pos")) - map_dot.width()/2;
            $(this).attr("style", "z-index: 2; position: absolute; top: "+offsetTop+"px; left: "+offsetLeft+"px;");
          });
        });
      </script> 


      <map name="map" id="map">
      <area id="uebersichts_map_area" 
        shape="poly" 
        coords="2,103,3,103,181,103,181,3,197,3,197,104,502,103,502,2,516,2,517,104,883,104,883,118,707,119,707,249,692,249,692,118,517,118,517,249,502,248,502,118,197,119,197,248,181,248,181,118,2,118,2,102" 
        href="#" 
        alt="" />

      <area shape="poly" coords="9,64,10,64,61,64,61,72,83,72,83,64,161,64,161,6,8,6,8,65" href="#" alt="" />
      </map>
      <script>console.log("<?= $sql_map_path ?>")</script>
      <img src="assets/img/uebersichtskarte.jpg"  border="0" alt="Übersichtskarte" title="" usemap="#map" id="uebersichts_map" style="position: absolute; top:150px; left:100px" />


      <form method="POST" style="position: absolute; top:410px; left:100px">
        <?php
          echo("<select name='ID' id='photo_pick' class='selectpicker'>");
          foreach ($hsh as $key => $value) {
            $key += 1;
            echo("<option value='" .$key. "'>" .$value["photo_name"]. "</option>");
          };
          echo("</select>");
        ?>

        <input type="text" name="x_position" id="uebersichts_map_X" placeholder="X Position">
        <input type="text" name="y_position" id="uebersichts_map_Y" placeholder="Y Position">
        <button type="submit" class="btn btn-success">Speichern</button>
      </form>
      <hr>

      <footer>
        <p>&copy; VCL 2013</p>
      </footer>
    </div> <!-- /container -->        
    <!-- 
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
        -->
    </body>
</html>
