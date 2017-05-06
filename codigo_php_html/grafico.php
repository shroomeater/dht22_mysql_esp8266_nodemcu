<!DOCTYPE html>
<html lang="en">
<head>
  <title>Gráfico de Temperatura - ESP8266 + PHP + MYSQL</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <meta http-equiv='refresh' content='60' URL=''>    
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <!-- JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <!-- Google Chart -->  
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>

<?
//Dessabilita a exibição de erros
error_reporting(0);
ini_set(“display_errors”, 0 );

//Inclui a conexão com o BD
include 'init.php';

//Faz o SELECT da tabela
$sql = mysql_query("SELECT * FROM temp");

//Cria o array primário
$dados = array();

	//Laço dos dados
	while ($linha = mysql_fetch_assoc($sql)) {

	//Cria o array secundário, onde estarão os dados.
    $temp_hora = array();

    $temp_hora[] = ((string) $linha['hora']);
    $temp_hora[] = ((float) $linha['temperatura']);

    //Recebe no array principal, os dados.
    $dados[] = ($temp_hora);

  }

  //Trasforma os dados em JSON
  $jsonTable = json_encode($dados);
  //echo $jsonTable;


?>

<h3 align="center">ESP8266 + MYSQL + PHP + GOOGLE CHART</h3>

<!-- Div do Gráfico -->
<div class="container" style="height: 300px; width: 100%" id="chart_div"></div>

<br><br>

</body>

<script>
//Script do Google que define o TIPO do gráfico
google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawBackgroundColor);

//Define o tipo de coluna e o nome
function drawBackgroundColor() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Hora do Dia');
      data.addColumn('number', 'Temperatura (ºC)');
	   
      //Pega os dados em JSON e monta o gráfico, de acordo com os dados.
      data.addRows( <? echo $jsonTable ?>);

      //Opções do gráfico:		
      var options = {
        hAxis: {
          title: 'Hora'
        },
        vAxis: {
          title: 'Temperatura'
        },
        backgroundColor: '#f1f8e9'
      };

      //Criação do Gráfico	
      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }

</script>

</html>
