<?php
/**
 * Stellt die Verbindung zur Datenbank her
 *
 * @var string MySQL-Hostname
 * @var string Benutzername
 * @var string Benutzerkennwort
 * @var string Name der Datenbank
 * @return resource MySQL Verbindungs-Kennung
 */
function connect($MYSQL_host, $MYSQL_user, $MYSQL_passw, $db)
{
	$linkid = mysql_pconnect($MYSQL_host, $MYSQL_user, $MYSQL_passw) or die(mysql_error());
	mysql_select_db($db) or die(mysql_error());

	sql("SET NAMES 'utf8'");
	sql("SET CHARACTER SET 'utf8'");

	return $linkid;
}
?>