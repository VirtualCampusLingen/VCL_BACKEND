<?php
/**
 * Stellt die Verbindung zur Datenbank her
 *
 * @return resource MySQL Verbindungs-Kennung
 */
function connect()
{
	$linkid = mysql_pconnect('localhost', 'user_vcl', 'fvv!22wDcF') or die(mysql_error());
	mysql_select_db('db_vcl') or die(mysql_error());

	sql("SET NAMES 'utf8'");
	sql("SET CHARACTER SET 'utf8'");

	return $linkid;
}
?>