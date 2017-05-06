<?php
//Desabilita a exibição de erros
error_reporting(0);
ini_set(“display_errors”, 0 );

//Incluimos o código de conexão ao BD
include 'init.php';

//Variável responsável por guardar o valor enviada pelo ESP8266
$temperatura = $_GET['temp'];

//Captura a Data e Hora do SERVIDOR (onde está hospedada sua página):
$hora = date('H:i:s');
$data = date('Y-m-d');

//Insere no Banco de Dados
$sql = mysql_query("INSERT INTO temp (data, hora, temperatura) VALUES ('$data', '$hora', '$temperatura')");
?>
