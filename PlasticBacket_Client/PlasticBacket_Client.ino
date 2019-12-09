#include<ESP8266WiFi.h>
#include<FirebaseArduino.h>

//User กับ Pass ของ WIFI
const char* user = "Nest";
const char* pass = "0819296842";

//Host ของ Firebase กับ รหัสยืนยันตัวของ Firebase
#define Firebase_HOST "plasticbucket-cb721.firebaseio.com"
#define Firebase_AUT "wZHkaLYqMN3nTecN0t33Pe8HsANOwk2YYI5jFGig"


int checker = 50;

// Connect to WIFI
void connect(){

  // set user and pass ของ WIFI
  WiFi.begin(user, pass);

  //ถ้าเชื่อมไม่ติดจะทำการ show '.' ไปจนกว่าจะเชื่อมติด
  while(WiFi.status() != WL_CONNECTED){
    Serial.print(".");
    delay(1000);
  }

  //เชื่อมติด Show ข้อความ 'Connected' และ Show IP
  Serial.println("Connected");
  Serial.print("IP: ");
  Serial.println(WiFi.localIP());
}

//ตั้งค่าต่างๆของ NODEMCU WIFI มีการเรียกการ connect
void setup() {
  Serial.begin(9600);
  connect();
  Firebase.begin(Firebase_HOST, Firebase_AUT);
}

// ส่วนตรงนี้จะเป็นการทำงานซ้ำๆเรื่อยๆ
void loop() {
  //ตั้งค่า path และ id ที่อยู่บน firebase
  String ID = "ID_01/Value";
  String path = "/NodeMCU/" + ID;
  
  // อ่านค่าจาก sensor มาเก็บไว้ใน sensor_value
  int sensor_value = analogRead(A0);

  // โยนค่าขึ้นไปบน Firebase ด้วยคำสั่ง Firebase.setInt(ที่อยู่, ค่า);
  Firebase.setInt(path, sensor_value);

  // Show value ผ่านทาง Serial Monitor
  Serial.println(sensor_value);
  delay(5000);
  
  
  
}
