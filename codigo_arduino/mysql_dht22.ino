/*//////////////////////////////////////////////////////////////////////////////////////////////////////////
//Arquivo:      DHT11.ino
//Tipo:         Codigo-fonte para utilizar no ESP8266 (nodeMCU) atraves da IDE do Arduino
//Autor:        Marco Rabelo para o canal Infortronica Para Zumbis (www.youtube.com/c/InfortronicaParaZumbis)
//Modificado:   Guilherme Lirio Tomasi de Oliveira
//Descricao:    Lendo o sensor de Temperatura e Umidade (DHT11) e enviando a temperatura para banco de dados.           
///////////////////////////////////////////////////////////////////////////////////////////////////////////*/

/*
  Comparação das saidas Digitais entre nodeMCU - Arduino

  NodeMCU – Arduino

  D0 = 16;
  D1 = 5;
  D2 = 4;
  D3 = 0;
  D4 = 2; //IR
  D5 = 14;
  D6 = 12;
  D7 = 13;
  D8 = 15;
  D9 = 3;
  D10 = 1;

*/

//Incluindo as bibliotecas necessárias
#include <ESP8266WiFi.h>
#include <DHT.h>

// Nome da sua rede Wifi
const char* ssid = "SSID de tu WIFI";

// Senha da rede
const char* password = "CLAVE de TU wifi";


// Pino do DHT
#define DHTPIN D7

// Definindo o sensor como DHT11
#define DHTTYPE DHT22

// Inicializando o sensor DHT
DHT dht(DHTPIN, DHTTYPE);

// Site que receberá os dados - IMPORTANTE: SEM O HTTP://
const char* host = "leaflet.esy.es"; //mysql.hostinger.es

void setup() {
  // Iniciando o Serial
  Serial.begin(115200);
  
  // Iniciando o DHT 
  dht.begin();

  // Conectando na rede wifi
  Serial.println("");
  Serial.print("Conectando");
  WiFi.begin(ssid, password);  
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Conectado a rede: ");
  Serial.println(ssid);
}

void loop() {
  // Criando uma conexao TCP
  WiFiClient client;
  const int httpPort = 80;
  if (!client.connect(host, httpPort)) {
    return;
  }
  
  // Lendo a temperatura em graus Celsius
  int t = dht.readTemperature();
  
  // Enviando para o host a temperatura lida.
  client.print(String("GET /dht11.php?temp=") + (t) +
                      " HTTP/1.1\r\n" + "Host: " + host + "\r\n" + "Connection: close\r\n\r\n");
  
  // Repetindo a cada 1 minuto
  delay(60000);
  Serial.print("Temperatura enviada: ");
  Serial.println(t);
}
