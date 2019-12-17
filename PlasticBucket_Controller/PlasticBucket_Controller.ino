#include<ESP8266WiFi.h>
#include<FirebaseArduino.h>
// Import Library ESP8266WiFi กับ FirebaseArduino

//User กับ Pass ของ WIFI เป็น ตัวแปร Pointer ที่เป็น Constant
const char* user = "Username ของ WiFi";
const char* pass = "Password ของ WiFi";

int counter = 0; // ตัวแปรในการนับขวดพลาสติก

//Host ของ Firebase กับ รหัสยืนยันตัวของ Firebase ซึ่งจากที่เห็นนี้เป็น ของ Project Plastic Bucket
#define Firebase_HOST "plasticbucket-cb721.firebaseio.com"
#define Firebase_AUT "wZHkaLYqMN3nTecN0t33Pe8HsANOwk2YYI5jFGig"


// Function Setup WiFi โดยการเชื่อมต่อไปยัง user กับ pass ที่ใส่ในตัวเปร const char* user and const char* pass
void setup_wifi(){

  // set user and pass ของ WIFI
  WiFi.begin(user, pass);

  //ถ้าเชื่อมไม่ติดจะทำการ show '.' ไปจนกว่าจะเชื่อมติด
  while(WiFi.status() != WL_CONNECTED){
    Serial.println(".");
    delay(1000);
  }

  //เชื่อมติด Show ข้อความ 'Connected' และ Show IP
  Serial.println("Connected");
  Serial.print("IP: ");
  Serial.println(WiFi.localIP());
}

//ตั้งค่าต่างๆของ NODEMCU WIFI มีการเรียกการ Connect
void setup() {
  Serial.begin(500000); // กำหนดความเร็วของ NodeMCU ESP8266 WiFi
  setup_wifi();
  Firebase.begin(Firebase_HOST, Firebase_AUT); // เชื่อมต่อ Firebase
}

// ส่วนตรงนี้จะเป็นการทำงานซ้ำๆเรื่อยๆ
void loop() {
  //ตั้งค่า path และ id ที่อยู่บน firebase
  String ID = "ID_01/Value";
  String path = "/NodeMCU/" + ID;

  
  // อ่านค่าจาก sensor มาเก็บไว้ใน sensor_value
  int sensor_value = analogRead(A0);

  // ถ้าค่าอยู่ระหว่าง 70 ถึง 800 จะถือว่าเป็นขวดพลาสติก
  if(sensor_value >= 70 && sensor_value <= 800){
    counter++; // นับขวดพลาสติกที่ถูกใส่ลงมาเเล้ว
    Firebase.setInt("/NodeMCU/ID_01/Plastic_Bottle", counter); // Set ค่าไปที่ Firebase
  }
  // Set ค่าขึ้นไปบน Firebase ด้วยคำสั่ง Firebase.setInt(ที่อยู่, ค่า);
  Firebase.setInt(path, sensor_value);

  // Show value ผ่านทาง Serial Monitor
  Serial.println(sensor_value);
  delay(1000);// มีการ Delay 1000 millisec หรือ 1 sec เช่น ถ้า 2000 ก็จะเป็น 2 sec
  
  
  
}
