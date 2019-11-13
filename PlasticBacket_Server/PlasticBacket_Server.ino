#include<ESP8266WiFi.h>
#include<PubSubClient.h>

const char* user = "Nest";
const char* pass = "0819296842";

const char* topic = "admin - Tester";
#define mqtt_server "tailor.cloudmqtt.com"
#define port 17419
#define mq_user "tzhuoesh"
#define mq_pass "LgwzXlz1T1Da"

WiFiClient espClient;
PubSubClient client(espClient);


void setup() {
  Serial.begin(9600);
  WiFi.begin(user, pass);
  while(WiFi.status() != WL_CONNECTED){
   Serial.print(".");
   delay(500);
  }
  Serial.println("Connected");
  Serial.print("IP: ");
  Serial.println(WiFi.localIP());

  client.setServer(mqtt_server, port);
  client.setCallback(callback);
}

void reconnect(){
  while(!client.connected()){
    Serial.println("Wait..");
    String clientId = "ESP8266Client-";
    clientId += String(random(0xffff), HEX);
    if (client.connect(clientId.c_str(), mq_user, mq_pass)) {
      Serial.println("Connected");
      client.subscribe(topic);
      Serial.println("Subscribe");
    } else {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println("Wait 5 Second");
      delay(5000);
    }
  }
}

void loop() {
  if(!client.connected()){
    reconnect();
  }
  client.loop();

}
void callback(char* topic, byte* payload, unsigned int length){
  Serial.print("Message from : ");
  Serial.println(topic);
  String msg = "";
  int i = 0;
  String Status = "";
  while(i < length){
    msg += (char)payload[i++];
  }
  Serial.println(msg);
  for(int i = 7;i < 9; i++){
    Status += msg[i];
  }
  if(Status == "ON"){
    Serial.println("Checking Bluetooh");
  }
}
