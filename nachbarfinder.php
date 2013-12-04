<?php
	$DOCUMENT_ROOT = dirname(__FILE__);

	$tools_dir = $DOCUMENT_ROOT . "/tools/";
	include_once($tools_dir . "connect.php");
	include_once($tools_dir . "sql.php");
	$dblk = connect();
    
    if($_GET['id'] > 0) {
		$id = mysql_real_escape_string($_GET['id']);
	}
    else{
        $id = 1;
    }
    
    $sql1 = sql("SELECT `x_position`,`y_position` FROM `photo` WHERE `ID` = ".$id." ");

    while ($row = mysql_fetch_assoc($sql1)) {
        $photo_x = intval($row['x_position']);
        $photo_y = intval($row['y_position']);
    }
    
    echo "Ausgangspunkt:<br/>";
    echo "X: ".$photo_x." <br/> ";
    echo "Y: ".$photo_y." <br/><br/> ";

    //SQL für rechts x
    echo "SELECT `ID`, `x_position`, `y_position` FROM `photo` WHERE `ID` != '".$id."' AND `x_position` > ".$photo_x." ORDER BY  `photo`.`x_position` LIMIT 0 , 1 <br/>";
    $sql_right_x_neighbour = sql("SELECT `ID`, `x_position`, `y_position` FROM `photo` WHERE `ID` != '".$id."' AND `x_position` > ".$photo_x." ORDER BY  `photo`.`x_position` LIMIT 0 , 1");
  
    //SQL für links x
    echo "SELECT `ID`, `x_position`, `y_position` FROM `photo` WHERE `ID` != '".$id."' AND `x_position` < ".$photo_x." ORDER BY  `photo`.`x_position` LIMIT 0 , 1 <br/>";
    $sql_left_x_neighbour = sql("SELECT `ID`, `x_position`, `y_position` FROM `photo` WHERE `ID` != '".$id."' AND `x_position` < ".$photo_x." ORDER BY  `photo`.`x_position` LIMIT 0 , 1");

    if($sql_right_x_neighbour){
        echo "<br/><br/>";
        echo "Nachbar rechts auf der x Achse";
            while ($row = mysql_fetch_assoc($sql_right_x_neighbour)) {
                echo "<br/><br/>";
                echo "Nachbar rechts:<br/>";
                echo "X: ".$row['x_position']."<br/>";
                echo "Y: ".$row['y_position']."<br/>";
                echo "ID: ".$row['ID']."<br/>";

                $neighbour[$row['ID']] = array('X'=>$row['x_position'],'Y'=>$row['y_position'],'id'=>$row['ID']);

            }
    }else{
        echo "<br/><br/>";
        echo "Kein nachbar?!? rechts <br/>";
    }
    
    if($sql_left_x_neighbour){
        echo "<br/><br/>";
        echo "Nachbar links auf der x Achse";
                while ($row = mysql_fetch_assoc($sql_left_x_neighbour)) {
                echo "<br/><br/>";
                echo "Nachbar links:<br/>";
                echo "X: ".$row['x_position']."<br/>";
                echo "Y: ".$row['y_position']."<br/>";
                echo "ID: ".$row['ID']."<br/>";
                $neighbour[$row['ID']] = array('X'=>$row['x_position'],'Y'=>$row['y_position'],'id'=>$row['ID']);
            }
    }else{
        echo "<br/><br/>";
        echo "Kein nachbar?!? links <br/>";
    }
    
    
    //SQL für hoch y
    echo "SELECT `ID`, `x_position`, `y_position` FROM `photo` WHERE `ID` != '".$id."' AND `y_position` > ".$photo_y." ORDER BY  `photo`.`y_position` LIMIT 0 , 1 <br/>";
    $sql_top_y_neighbour = sql("SELECT `ID`, `x_position`, `y_position` FROM `photo` WHERE `ID` != '".$id."' AND `y_position` > ".$photo_y." ORDER BY  `photo`.`y_position` LIMIT 0 , 1");
  
    //SQL für tief x
    echo "SELECT `ID`, `x_position`, `y_position` FROM `photo` WHERE `ID` != '".$id."' AND `y_position` < ".$photo_y." ORDER BY  `photo`.`y_position` LIMIT 0 , 1 <br/>";
    $sql_bottom_y_neighbour = sql("SELECT `ID`, `x_position`, `y_position` FROM `photo` WHERE `ID` != '".$id."' AND `y_position` < ".$photo_y." ORDER BY  `photo`.`y_position` LIMIT 0 , 1");
    
    if($sql_top_y_neighbour){
        echo "<br/><br/>";
        echo "Nachbar top auf der y Achse";
            while ($row = mysql_fetch_assoc($sql_top_y_neighbour)) {
                echo "<br/><br/>";
                echo "Nachbar top:<br/>";
                echo "X: ".$row['x_position']."<br/>";
                echo "Y: ".$row['y_position']."<br/>";
                echo "ID: ".$row['ID']."<br/>";
                $neighbour[$row['ID']] = array('X'=>$row['x_position'],'Y'=>$row['y_position'],'id'=>$row['ID']);
            }
    }else{
        echo "<br/><br/>";
        echo "Kein nachbar?!? top <br/>";
    }
    
    if($sql_bottom_y_neighbour){
        echo "<br/><br/>";
        echo "Nachbar bottom auf der y Achse";
                while ($row = mysql_fetch_assoc($sql_bottom_y_neighbour)) {
                echo "<br/><br/>";
                echo "Nachbar bottom:<br/>";
                echo "X: ".$row['x_position']."<br/>";
                echo "Y: ".$row['y_position']."<br/>";
                echo "ID: ".$row['ID']."<br/>";
                $neighbour[$row['ID']] = array('X'=>$row['x_position'],'Y'=>$row['y_position'],'id'=>$row['ID']);
            }
    }else{
        echo "<br/><br/>";
        echo "Kein nachbar?!? bottom <br/>";
    }
    

    echo "<pre>";
    var_dump($neighbour);
    echo "</pre>";

    foreach($neighbour as $n)
    {
        if($n['Y'] > $photo_y)
        {
            $a = $n['Y'] - $photo_y;
        }
        else 
        {
            $a = $photo_y - $n['Y'];
        }

        if($n['X'] > $photo_x)
        {
            $b = $n['X'] - $photo_x;
        } 
        else 
        {
            $b = $photo_x - $n['X'];
        }
        echo "<br/>Rechnung: (".$a.")2  +  (".$b.")2 = (c)2<br/>";
        $c = sqrt(pow($a,2) + pow($b, 2));
        echo "Entfernung von Punkt ".$id." zu Punkt ".$n['id']." = ".$c."<br/><br/>";
        echo "Winkel: ".(180-(sin($b/$c)))."<br/>";
        echo "Winkel: ".sin($b/$c)."<br/>";
        echo "Winkelsumme: ".(sin($b/$c))+(90)+(180-sin($b/$c))."<br/>";
    }


?>
