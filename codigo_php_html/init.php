<?
//Desabilita a exibição de erros
error_reporting(0);
ini_set(“display_errors”, 0 );

header('Content-Type: text/html; charset=utf-8');
mysql_connect('DBHOST','DBUSER','DBPASS');
mysql_select_db('DBNAME');
?>
