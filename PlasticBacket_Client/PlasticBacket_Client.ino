#include<ESP8266WiFi.h>
#include<FirebaseArduino.h>

const char* user = "Nest";
const char* pass = "0819296842";
#define Firebase_HOST "plasticbucket-cb721.firebaseio.com"
#define Firebase_AUT "wZHkaLYqMN3nTecN0t33Pe8HsANOwk2YYI5jFGig"


int checker = 50;

void setup() {
  Serial.begin(9600);
  WiFi.begin(user, pass);

  while(WiFi.status() != WL_CONNECTED){
    Serial.print(".");
    delay(1000);
  }
  
  Serial.println("Connected");
  Serial.print("IP: ");
  Serial.println(WiFi.localIP());

  Firebase.begin(Firebase_HOST, Firebase_AUT);
}

void loop() {
  String ID = "ID_01/Value";
  String path = "/NodeMCU/" + ID;
  int sensor_value = analogRead(A0);

    Firebase.setInt(path, sensor_value);
    Serial.println(sensor_value);
    delay(5000);
  
  
  
}
