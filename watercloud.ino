#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

const char* ssid = "The best";
const char* password = "MACHIDABA";

//Your Domain name with URL path or IP address with path
const char* serverName = "http://192.168.0.106:8080/WaterCloud/esp_data.php";




int infra = 13;
int ledg = 5;
int ledr = 4;
boolean stopping = false;
void setup() {
 Serial.begin(9600);
 pinMode(infra, INPUT);// set pin as input
 pinMode(ledg, OUTPUT);
 pinMode(ledr, OUTPUT);
 WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
}
void loop() {
  


  if(WiFi.status()== WL_CONNECTED){
      HTTPClient http;
      
      int detect = digitalRead(infra);
      while(detect == LOW && stopping == false){
     
        //Send  post  request 
        http.begin(serverName);
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");
        String httpRequestData = "key=Rox01nDxb";
        int httpResponseCode = http.POST(httpRequestData);
        Serial.print("HTTP Response code: ");
        Serial.println(httpResponseCode);

        
           digitalWrite(ledg,HIGH);
           delay(10000);
           digitalWrite(ledg,LOW);
           stopping = true;
           digitalWrite(ledr,HIGH);
           delay(400);
           digitalWrite(ledr,LOW);
        
        }
      if(detect == HIGH){
        stopping = false;
        }
     


      
    }
}
