<?php
/**
 * Sendet eine Anfrage an MySQL
 *
 * @var string Anfrage
 * @return resource MySQL Ressourcen-Kennung
 */
function sql($sql, $debug = false)
{
	if ($debug === true) {
		echo $sql."<br>";
	} else {
		$res = mysql_query($sql);
		if(is_null($res) || !$res) {
			write_log(date("d.m.Y H:i:s")." - Statement fehlerhaft: ");
			write_log(date("d.m.Y H:i:s")." - Stacktrace");
			throw new Exception( mysql_error()."\n------------------------\n\n".$sql."\n");
		}
	}

	return $res;
}
?>