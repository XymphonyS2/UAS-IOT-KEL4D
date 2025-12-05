#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>
#include <DHT.h>
#include <ESP32Servo.h>

const char* ssid = "Sikat";
const char* password = "ilalalala";
const char* serverURL = "http://10.136.128.130/web/api/esp32_data.php";

#define DHT_PIN         32
#define LDR_PIN         34
#define MQ135_PIN       35

#define RELAY_KIPAS_MASUK     17
#define RELAY_KIPAS_KELUAR    16
#define RELAY_LAMPU_HANGAT    18
#define RELAY_LAMPU_TERANG    5

#define SERVO_PIN       13

#define BUZZER_PIN      21 

#define SUHU_DINGIN_MAX     29.5
#define SUHU_PANAS_MIN      30.5

#define GAS_TINGGI_THRESHOLD  400

#define LDR_GELAP_THRESHOLD   2000

#define DHT_TYPE DHT11
DHT dht(DHT_PIN, DHT_TYPE);

Servo conveyorServo;
int servoSpeed = 0;

#define RELAY_ON    LOW
#define RELAY_OFF   HIGH

float suhu = 0;
float kelembapan = 0;
int nilaiGas = 0;
int nilaiLDR = 0;

String statusSuhu = "";
String statusGas = "";
String statusCahaya = "";

bool conveyorStatus = false;

bool kipasmasukState = false;
bool kipasKeluarState = false;
bool lampuHangatState = false;
bool lampuTerangState = false;

bool manualKipasMasuk = false;
bool manualKipasKeluar = false;
bool manualLampuHangat = false;
bool manualLampuTerang = false;
bool manualConveyor = false;

bool manualKipasMasukValue = false;
bool manualKipasKeluarValue = false;
bool manualLampuHangatValue = false;
bool manualLampuTerangValue = false;
bool manualConveyorValue = false;

unsigned long lastReadTime = 0;
unsigned long lastSendTime = 0;
const unsigned long READ_INTERVAL = 2000;
const unsigned long SEND_INTERVAL = 3000;

void bacaSensor();
void tentukanStatus();
void kontrolAktuator();
void tampilkanData();
void setRelay(int pin, bool state);
void setConveyor(bool state);
void setBuzzer(bool state);
void connectWiFi();
void sendDataToServer();
void getControlFromServer();

void setup() {
  Serial.begin(115200);
  Serial.println("\n========================================");
  Serial.println("   CIMON - Smart Monitoring System");
  Serial.println("========================================\n");

  dht.begin();

  pinMode(RELAY_KIPAS_MASUK, OUTPUT);
  pinMode(RELAY_KIPAS_KELUAR, OUTPUT);
  pinMode(RELAY_LAMPU_HANGAT, OUTPUT);
  pinMode(RELAY_LAMPU_TERANG, OUTPUT);

  pinMode(BUZZER_PIN, OUTPUT);
  digitalWrite(BUZZER_PIN, LOW);

  digitalWrite(RELAY_KIPAS_MASUK, RELAY_OFF);
  digitalWrite(RELAY_KIPAS_KELUAR, RELAY_OFF);
  digitalWrite(RELAY_LAMPU_HANGAT, RELAY_OFF);
  digitalWrite(RELAY_LAMPU_TERANG, RELAY_OFF);

  ESP32PWM::allocateTimer(0);
  ESP32PWM::allocateTimer(1);
  ESP32PWM::allocateTimer(2);
  ESP32PWM::allocateTimer(3);
  conveyorServo.setPeriodHertz(50);
  conveyorServo.attach(SERVO_PIN, 500, 2400);
  conveyorServo.write(90);

  analogReadResolution(12);
  analogSetAttenuation(ADC_11db);

  connectWiFi();

  Serial.println("Sistem siap!\n");
  delay(2000);
}

void connectWiFi() {
  Serial.print("Connecting to WiFi");
  WiFi.begin(ssid, password);
  
  int attempts = 0;
  while (WiFi.status() != WL_CONNECTED && attempts < 30) {
    delay(500);
    Serial.print(".");
    attempts++;
  }
  
  if (WiFi.status() == WL_CONNECTED) {
    Serial.println("\nWiFi Connected!");
    Serial.print("IP Address: ");
    Serial.println(WiFi.localIP());
  } else {
    Serial.println("\nWiFi Connection Failed! Running in offline mode.");
  }
}

void loop() {
  unsigned long currentTime = millis();

  if (WiFi.status() != WL_CONNECTED) {
    connectWiFi();
  }

  if (currentTime - lastReadTime >= READ_INTERVAL) {
    lastReadTime = currentTime;

    bacaSensor();
    tentukanStatus();
    kontrolAktuator();
    tampilkanData();
  }

  if (currentTime - lastSendTime >= SEND_INTERVAL) {
    lastSendTime = currentTime;
    
    if (WiFi.status() == WL_CONNECTED) {
      sendDataToServer();
      getControlFromServer();
    }
  }
}

void bacaSensor() {
  float tempSuhu = dht.readTemperature();
  float tempKelembapan = dht.readHumidity();

  if (!isnan(tempSuhu) && !isnan(tempKelembapan)) {
    suhu = tempSuhu;
    kelembapan = tempKelembapan;
  } else {
    Serial.println("Error: Gagal membaca DHT sensor!");
  }

  nilaiGas = analogRead(MQ135_PIN);

  nilaiLDR = analogRead(LDR_PIN);
}

void tentukanStatus() {
  if (suhu < SUHU_DINGIN_MAX) {
    statusSuhu = "DINGIN";
  } else if (suhu >= SUHU_DINGIN_MAX && suhu <= SUHU_PANAS_MIN) {
    statusSuhu = "NORMAL";
  } else {
    statusSuhu = "PANAS";
  }

  if (nilaiGas >= GAS_TINGGI_THRESHOLD) {
    statusGas = "TINGGI";
  } else {
    statusGas = "NORMAL";
  }

  if (nilaiLDR > LDR_GELAP_THRESHOLD) {
    statusCahaya = "GELAP";
  } else {
    statusCahaya = "TERANG";
  }
}

void kontrolAktuator() {
  bool kipasmasuk = false;
  bool kipasKeluar = false;
  bool lampuHangat = false;
  bool conveyor = false;
  bool lampuTerang = false;

  
  if (statusSuhu == "DINGIN" && statusGas == "NORMAL") {
    kipasmasuk = false;
    kipasKeluar = false;
    lampuHangat = true;
    conveyor = false;
  }
  else if (statusSuhu == "DINGIN" && statusGas == "TINGGI") {
    kipasmasuk = true;
    kipasKeluar = true;
    lampuHangat = true;
    conveyor = true;
  }
  else if (statusSuhu == "NORMAL" && statusGas == "NORMAL") {
    kipasmasuk = false;
    kipasKeluar = false;
    lampuHangat = false;
    conveyor = false;
  }
  else if (statusSuhu == "NORMAL" && statusGas == "TINGGI") {
    kipasmasuk = true;
    kipasKeluar = true;
    lampuHangat = false;
    conveyor = true;
  }
  else if (statusSuhu == "PANAS" && statusGas == "NORMAL") {
    kipasmasuk = true;
    kipasKeluar = true;
    lampuHangat = false;
    conveyor = false;
  }
  else if (statusSuhu == "PANAS" && statusGas == "TINGGI") {
    kipasmasuk = true;
    kipasKeluar = true;
    lampuHangat = false;
    conveyor = true;
  }

  if (statusCahaya == "GELAP") {
    lampuTerang = true;
  } else {
    lampuTerang = false;
  }

  if (manualKipasMasuk) {
    kipasmasuk = manualKipasMasukValue;
  }
  if (manualKipasKeluar) {
    kipasKeluar = manualKipasKeluarValue;
  }
  if (manualLampuHangat) {
    lampuHangat = manualLampuHangatValue;
  }
  if (manualLampuTerang) {
    lampuTerang = manualLampuTerangValue;
  }
  if (manualConveyor) {
    conveyor = manualConveyorValue;
  }

  kipasmasukState = kipasmasuk;
  kipasKeluarState = kipasKeluar;
  lampuHangatState = lampuHangat;
  lampuTerangState = lampuTerang;
  conveyorStatus = conveyor;

  setRelay(RELAY_KIPAS_MASUK, kipasmasuk);
  setRelay(RELAY_KIPAS_KELUAR, kipasKeluar);
  setRelay(RELAY_LAMPU_HANGAT, lampuHangat);
  setRelay(RELAY_LAMPU_TERANG, lampuTerang);

  setConveyor(conveyor);

  setBuzzer(conveyor);
}

void setRelay(int pin, bool state) {
  if (state) {
    digitalWrite(pin, RELAY_ON);
  } else {
    digitalWrite(pin, RELAY_OFF);
  }
}

void setConveyor(bool state) {
  if (state) {
    conveyorServo.write(0);
  } else {
    conveyorServo.write(90);
  }
}

void setBuzzer(bool state) {
  if (state) {
    digitalWrite(BUZZER_PIN, HIGH);
  } else {
    digitalWrite(BUZZER_PIN, LOW);
  }
}

void sendDataToServer() {
  HTTPClient http;
  
  http.begin(serverURL);
  http.addHeader("Content-Type", "application/json");

  StaticJsonDocument<512> doc;
  doc["suhu"] = suhu;
  doc["kelembapan"] = kelembapan;
  doc["gas"] = nilaiGas;
  doc["cahaya"] = nilaiLDR;
  doc["status_suhu"] = statusSuhu;
  doc["status_gas"] = statusGas;
  doc["status_cahaya"] = statusCahaya;
  doc["kipas_masuk"] = kipasmasukState ? 1 : 0;
  doc["kipas_keluar"] = kipasKeluarState ? 1 : 0;
  doc["lampu_hangat"] = lampuHangatState ? 1 : 0;
  doc["lampu_terang"] = lampuTerangState ? 1 : 0;
  doc["conveyor"] = conveyorStatus ? 1 : 0;
  doc["buzzer"] = conveyorStatus ? 1 : 0;
  doc["manual_kipas_masuk"] = manualKipasMasuk ? 1 : 0;
  doc["manual_kipas_keluar"] = manualKipasKeluar ? 1 : 0;
  doc["manual_lampu_hangat"] = manualLampuHangat ? 1 : 0;
  doc["manual_lampu_terang"] = manualLampuTerang ? 1 : 0;
  doc["manual_conveyor"] = manualConveyor ? 1 : 0;

  String jsonString;
  serializeJson(doc, jsonString);

  int httpResponseCode = http.POST(jsonString);

  if (httpResponseCode > 0) {
    String response = http.getString();
    Serial.println("Data sent successfully!");
    Serial.println("Response: " + response);
  } else {
    Serial.println("Error sending data: " + String(httpResponseCode));
  }

  http.end();
}

void getControlFromServer() {
  HTTPClient http;
  
  String controlURL = String(serverURL) + "?action=get_control";
  http.begin(controlURL);

  int httpResponseCode = http.GET();

  if (httpResponseCode > 0) {
    String response = http.getString();
    
    StaticJsonDocument<512> doc;
    DeserializationError error = deserializeJson(doc, response);

    if (!error) {
      manualKipasMasuk = doc["manual_kipas_masuk"] == 1;
      manualKipasKeluar = doc["manual_kipas_keluar"] == 1;
      manualLampuHangat = doc["manual_lampu_hangat"] == 1;
      manualLampuTerang = doc["manual_lampu_terang"] == 1;
      manualConveyor = doc["manual_conveyor"] == 1;

      manualKipasMasukValue = doc["kipas_masuk_value"] == 1;
      manualKipasKeluarValue = doc["kipas_keluar_value"] == 1;
      manualLampuHangatValue = doc["lampu_hangat_value"] == 1;
      manualLampuTerangValue = doc["lampu_terang_value"] == 1;
      manualConveyorValue = doc["conveyor_value"] == 1;

      Serial.println("Control data received!");
    }
  } else {
    Serial.println("Error getting control: " + String(httpResponseCode));
  }

  http.end();
}

void tampilkanData() {
  Serial.println("============================================");
  Serial.println("           CIMON - STATUS SISTEM");
  Serial.println("============================================");
  
  Serial.println("\n--- DATA SENSOR ---");
  Serial.print("Suhu         : ");
  Serial.print(suhu, 1);
  Serial.print(" °C (");
  Serial.print(statusSuhu);
  Serial.println(")");

  Serial.print("Kelembapan   : ");
  Serial.print(kelembapan, 1);
  Serial.println(" %");

  Serial.print("Gas (MQ135)  : ");
  Serial.print(nilaiGas);
  Serial.print(" (");
  Serial.print(statusGas);
  Serial.println(")");

  Serial.print("Cahaya (LDR) : ");
  Serial.print(nilaiLDR);
  Serial.print(" (");
  Serial.print(statusCahaya);
  Serial.println(")");

  Serial.println("\n--- STATUS AKTUATOR ---");
  Serial.print("Kipas Masuk      : ");
  Serial.print(kipasmasukState ? "HIDUP" : "MATI");
  Serial.println(manualKipasMasuk ? " [MANUAL]" : " [AUTO]");

  Serial.print("Kipas Keluar     : ");
  Serial.print(kipasKeluarState ? "HIDUP" : "MATI");
  Serial.println(manualKipasKeluar ? " [MANUAL]" : " [AUTO]");

  Serial.print("Lampu Penghangat : ");
  Serial.print(lampuHangatState ? "HIDUP" : "MATI");
  Serial.println(manualLampuHangat ? " [MANUAL]" : " [AUTO]");

  Serial.print("Lampu Penerangan : ");
  Serial.print(lampuTerangState ? "HIDUP" : "MATI");
  Serial.println(manualLampuTerang ? " [MANUAL]" : " [AUTO]");

  Serial.print("Conveyor         : ");
  Serial.print(conveyorStatus ? "BERPUTAR" : "BERHENTI");
  Serial.println(manualConveyor ? " [MANUAL]" : " [AUTO]");

  Serial.print("Buzzer           : ");
  Serial.println(conveyorStatus ? "HIDUP" : "MATI");

  Serial.println("\n--- WIFI STATUS ---");
  Serial.print("Status: ");
  Serial.println(WiFi.status() == WL_CONNECTED ? "Connected" : "Disconnected");
  if (WiFi.status() == WL_CONNECTED) {
    Serial.print("IP: ");
    Serial.println(WiFi.localIP());
  }

  Serial.println("\n--- KONDISI AKTIF ---");
  Serial.print("Kondisi: SUHU ");
  Serial.print(statusSuhu);
  Serial.print(" + GAS ");
  Serial.println(statusGas);

  Serial.println("\n============================================\n");
}