#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <SoftwareSerial.h>
#include <ArduinoJson.h>
 
SoftwareSerial nodemcu(D6, D5);
 
const char* ssid     = "...."; 
const char* password = ".......";
 
 
const char* serverName = "https://creolized-gardens.000webhostapp.com/post_foliasator_data.php";
 
String apiKeyValue = "tPmAT5Ab3j7F9";
 
void setup() {
 
  Serial.begin(9600);
  nodemcu.begin(9600);
  while (!Serial) continue;
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
 
  StaticJsonBuffer<1000> jsonBuffer;
  JsonObject& data = jsonBuffer.parseObject(nodemcu);
 
  if (data == JsonObject::invalid()) {
   
    jsonBuffer.clear();
    return;
  }
 
  int distance = data["distance"];
  int moisture = data["moisture"];
  int lightSensor = data["lightSensor"];
  float humidity = data["humidity"];
  float temperature = data["temperature"];

  if(WiFi.status()== WL_CONNECTED){
    WiFiClient client;
    HTTPClient http;
 
    http.begin(client, serverName);
 
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
 
    String httpRequestData = "api_key=" + apiKeyValue + "&distance=" + String(distance)
                          + "&moisture=" + String(moisture) + "&humidity=" + String(humidity)
                          + "&temperature=" + String(temperature) + "&lightSensor=" + String(lightSensor) + "";
    Serial.print("httpRequestData: ");
    Serial.println(httpRequestData);
 
    int httpResponseCode = http.POST(httpRequestData);
 
    if (httpResponseCode>0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
    }
    else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }
    http.end();
  }
  else {
    Serial.println("WiFi Disconnected");
  }
  delay(30000);
}
