#include <DHT.h>
#include <SoftwareSerial.h>
#include <ArduinoJson.h>
SoftwareSerial nodemcu(5, 6);

#define DHTPIN 2
#define DHTTYPE DHT22
DHT dht(DHTPIN, DHTTYPE);


int chk;
float humidity;
float temperature;
int trigpin = 8;  // Ez a távolságérzékelő Trig pinje
int echopin = 9;  // Ez a távolságérzékelő Echo pinje
int distance;     
int duration;     // Ebbe a változóba lesz eltárolva a távolság
int moistureSensor; 
int moisture;
int lightSensor;
const int szaraz = 820; 
const int nedves = 280;
const int relepin = A5;

void setup() {
  Serial.begin(9600);
  nodemcu.begin(9600);
  pinMode (trigpin, OUTPUT); 
  pinMode (echopin, INPUT);
  dht.begin();
  pinMode (relepin, OUTPUT);
}

int tavolsag(){   // Ez a távolság kiszámítására szolgáló függvény
  int fv;
  digitalWrite(trigpin, LOW);
  delayMicroseconds(2);
  digitalWrite(trigpin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigpin, LOW);
  duration = pulseIn (echopin, HIGH);
  fv = duration * 0.034 / 2;
  return fv;
}

void loop() {
  StaticJsonBuffer<1000> jsonBuffer;
  JsonObject& data = jsonBuffer.createObject();

  lightSensor = analogRead(A0); //light sensor
  distance = tavolsag();
  moistureSensor = analogRead(A1);
  moisture= map(moistureSensor, nedves, szaraz, 100, 0); //itt a fent említett map függvény
  humidity = dht.readHumidity();
  temperature= dht.readTemperature();
  /*if (moisture < 50)
    {
      digitalWrite (relepin, LOW);
      delay(3000);
    }
  digitalWrite (relepin, HIGH);*/

  data["distance"] = distance;
  data["moisture"] = moisture;
  data["humidity"] = humidity;
  data["temperature"] = temperature;
  data["lightSensor"] = lightSensor;

  data.printTo(nodemcu);
  jsonBuffer.clear();

  delay(5000);
}
