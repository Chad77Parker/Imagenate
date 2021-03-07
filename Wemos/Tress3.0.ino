#include <ArduinoJson.h>
#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include <ESP8266mDNS.h>
#include <WiFiUdp.h>
#include <ArduinoOTA.h>
#include <Servo.h>
#include <WebSocketsServer.h>
#include <math.h>
#include <sigma_delta.h>
const int networks=3;
const char* network[networks][2] = {{"TheHive","Drone23579"},{"DLINK","7777777777"},{"Xperia Z5_1594","7777777777"}};


const char* ssid1 = "TheHive"; 
const char* password1 = "Drone23579"; 
const char* ssid2 = "DLINK";
const char* password2 = "7777777777";
const char* ssid3 = "Xperia Z5_1594";
const char* password3 = "7777777777";

ESP8266WebServer server ( 80 );
WebSocketsServer webSocket=WebSocketsServer(81);
Servo sv1;

/* pin assignments */
#define tens D0        //TENS output 0
#define tens1 D3       //TENS output 1
#define tens2 D2       //TENS output 2
#define smps D1       //SMPS drive
#define led D4        //built in LED
#define vac D5        //Vacuum
#define pum D6        //Pump
#define sqz D7        //Squeeze
#define sv1p D8       //Servo
#define smpsOutV A0   //Voltage sense of smps

/* constants */
#
/* global variables */
unsigned int tensMF, tensF, tensPW = 0;
unsigned long CM, CF, CPW = 0;
unsigned long timestamp=0;
boolean tensState, MState, FState = 0;
int tensWS = 0;
unsigned int mf, mfOld, mfTemp, md, mdOld, mdTemp, pf, pfOld, pfTemp, pw, pwOld, pwTemp, v, vOld, vTemp, t ,vm = 0; 
int PWMOut = 0;
int smpsMillis = 0;
int MaxVolts = 150;
int Voltlimit, VoltRead = 0;
int WSnum=0;
boolean newdata = false;


/*Setup and initialise function*/
void setup ( void ) {
  //set pins
  pinMode (tens, OUTPUT );
  pinMode (tens1, OUTPUT);
  pinMode (tens2, OUTPUT);
  pinMode (smps, OUTPUT);
  pinMode (led, OUTPUT);
  pinMode (vac, OUTPUT);
  pinMode (pum, OUTPUT);
  pinMode (sqz, OUTPUT);
  sv1.attach(sv1p);
  pinMode(smpsOutV, INPUT);

  //initialise pins
  digitalWrite(smps, LOW);  
  digitalWrite(led, HIGH);
  sqzoff();
  vacoff();
  pumpoff();
  tensoff();
  
  Serial.begin ( 115200 );
  if(!ConnectWiFi()){
    Serial.println("Could not connect to WiFi");
    delay(5000);
    ESP.restart();
  }
  SetOTA();
  SetWebSocket();
  SetMDNS();
  SetWebServer();
  SetSMPS();

  digitalWrite(led, LOW);//display initialise passed
}

void loop ( void ) {
  //MDNS.update();
  ArduinoOTA.handle();
  server.handleClient();
  webSocket.loop();
  smpscontrol();
  tenscontrol();
  tensWScontrol();
}

bool ConnectWiFi(){
  WiFi.mode(WIFI_STA);
  int SigStrength = -100;
  int n = -1; 
  for (int i=0; i<networks;i++){
    WiFi.begin(network[i][0], network[i][1]);
    int x=0;
    while ( (WiFi.status() != WL_CONNECTED) && (x < 15) ) {
      delay ( 500 );
      x++;
      Serial.print (" "+x); 
    }
    if(WiFi.status() == WL_CONNECTED){
      Serial.println((String)network[n][0]+" Strength:"+WiFi.RSSI());
        if(WiFi.RSSI()>SigStrength){
           n=i;
           SigStrength=WiFi.RSSI();
    }
    }
    WiFi.disconnect();
  }
  Serial.println();
  Serial.println("Strongest network detected:"+(String)network[n][0]+".  Attempting to connect.");
    WiFi.begin (network[n][0] , network[n][1] ); 
    int x=0;
    while ( (WiFi.status() != WL_CONNECTED) && (x < 15) ) {
      delay ( 500 );
      x++;
      Serial.print ( "."); 
    }
    if(WiFi.status() != WL_CONNECTED){
      return false;
    }else{
      Serial.print ( "Connected to "+(String)network[n][0] );
      Serial.print ( "IP address: " );
      Serial.println ( WiFi.localIP() );
      Serial.println("Signal Strength:"+(String)SigStrength+" db");
      return true;
    }
}

void SetOTA(){
  //Set OverTheAir functionality
  ArduinoOTA.setHostname("MistressUpdate");
  // No authentication by default
  // ArduinoOTA.setPassword((const char *)"123");
  ArduinoOTA.onStart([]() {
    Serial.println("Start");
  });
  ArduinoOTA.onEnd([]() {
    Serial.println("\nEnd");
  });
  ArduinoOTA.onProgress([](unsigned int progress, unsigned int total) {
    Serial.printf("Progress: %u%%\r", (progress / (total / 100)));
  });
  ArduinoOTA.onError([](ota_error_t error) {
    Serial.printf("Error[%u]: ", error);
    if (error == OTA_AUTH_ERROR) Serial.println("Auth Failed");
    else if (error == OTA_BEGIN_ERROR) Serial.println("Begin Failed");
    else if (error == OTA_CONNECT_ERROR) Serial.println("Connect Failed");
    else if (error == OTA_RECEIVE_ERROR) Serial.println("Receive Failed");
    else if (error == OTA_END_ERROR) Serial.println("End Failed");
  });
  ArduinoOTA.begin();
}

void SetWebSocket(){
  // start webSocket server
    webSocket.begin();
    webSocket.onEvent(webSocketEvent);
}

void SetMDNS(){
   if (MDNS.begin("misstress")){
    Serial.println("MDNS responder started");
    MDNS.addService("http", "tcp", 80);
  }
}

void SetWebServer(){
  server.on ("", handleRoot );
  server.on ("/", handleRoot );
  server.on ("/s2on", s2on );
  server.on ("/s2off", s2off );
  server.on ("/sqzon", sqzon );
  server.on ("/sqzoff", sqzoff );
  server.on ("/vacon", vacon );
  server.on ("/vacoff", vacoff );
  server.on ("/pumpon", pumpon );
  server.on ("/pumpoff", pumpoff );
  server.on ("/servo1", servo1 );
  server.on ("/tenson", tenson );
  server.on ("/tensoff", tensoff );
  server.on ("/tensmaxvolts", tenssetmaxvolts );
  server.on ("/inline", []() {server.send ( 200, "text/plain", "this works as well" );  } );
  server.onNotFound ( handleNotFound );
  server.begin();
  Serial.println ( "HTTP server started" );
}

void SetSMPS(){
  sigmaDeltaEnable();
  sigmaDeltaSetPrescaler(255);
  sigmaDeltaWrite(0, 0);
  sigmaDeltaAttachPin(smps);
  Serial.println("Sigma Delta and SMPS Started");
  
}

void webSocketEvent(uint8_t num, WStype_t type, uint8_t * payload, size_t length) {
    String message;
    switch(type) {
        case WStype_DISCONNECTED:
            Serial.printf("[%u] Disconnected!\n", num);
            tensWS=false;
            break;
        case WStype_CONNECTED: {
            IPAddress ip = webSocket.remoteIP(num);
            Serial.printf("[%u] Connected from %d.%d.%d.%d url: %s\n", num, ip[0], ip[1], ip[2], ip[3], payload);
            WSnum = num;
            //send message to client
            message= "Connected:" + String(millis());
            webSocket.sendTXT(num, message);
        }
            break;
        case WStype_TEXT:
            Serial.printf("[%u] get Text: %s\n", num, payload);
            const size_t capacity = JSON_OBJECT_SIZE(6) + 20;
            DynamicJsonDocument doc(capacity);
            deserializeJson(doc, payload);
            vm=int(doc["vm"]);  //max volts in .2V steps
            if(vm){
              MaxVolts=vm;
            }else{
            mfOld=mf;
            mdOld=md;
            pfOld=pf;
            pwOld=pw;
            vOld=v;
            mf = int(doc["mf"])* 40 ;//modulation period in ms
            md = int(doc["md"]); // modulation duty cycle 256/256
            pf = int(1000000 /(pow(1.034, int(doc["pf"]))));// period in us
            pw = int(doc["pw"])*2; //pulse width in microseconds
            v = int(doc["v"]); // volts in .2V steps
            t = int(doc["t"])*40; // time in milliseconds to change
            if(!mf){ tensWS = false;
            }else {tensWS = true;}
            newdata = true;
            }
            timestamp=millis();
            message=String(timestamp);  //debug + "mf:"+mf+",md:"+md+",pf:"+pf+",pw:"+pw+",v:"+v+",t:"+t+",vm:"+vm+",VoltLimit:"+map(Voltlimit, 0, 255, 0, MaxVolts);
            webSocket.sendTXT(num, message);
            break;
    }

}

/*main program functions*/
void tenscontrol(){
if(!tensWS){unsigned long currentMillis = millis();
//Modulation
if (currentMillis-CM >= tensMF){
  CM = currentMillis;
   // if the Modulation is off turn it on and vice-versa:
   
    if (MState == 0) {
      MState = 1;
    } else {
      MState = 0;
    }
}
if(tensMF>10000){
  MState=1;
}

if (tensMF == 0){
  MState = 0;
}
//Frequency
unsigned long currentMicros = micros();
if (currentMicros-CF >= tensF){
  CF = currentMicros;
  //Frequency should be turned off by PulseWidth so only need to turn it on
  FState = 1;
  //set new CurrentPulseWidth start time
  CPW = currentMicros;
}
if (currentMicros-CPW >= tensPW){
  //PulseWidth should be turned on by Frequency so only need to turn off
  FState = 0;
 }

if (FState && MState && !tensState){
  digitalWrite(tens, HIGH);
  tensState=1;
  
}
if(!FState && MState && tensState){
  digitalWrite(tens, LOW);
  tensState=0;
  
}
if(!MState && tensState){
  digitalWrite(tens, LOW);
  tensState=0;
  
  }
}
} 

void tensWScontrol(){
if (tensWS){  
  if(newdata){ //if new data sent, calculate values until time t has elapsed 
    mfTemp= (mf==mfOld) ? mf : CalcAmplitude(mfOld, mf, t, millis()-timestamp);
    mdTemp= (md==mdOld) ? md : CalcAmplitude(mdOld, md, t, millis()-timestamp);
    pfTemp= (pf==pfOld) ? pf : CalcAmplitude(pfOld, pf, t, millis()-timestamp);
    pwTemp= (pw==pwOld) ? pw : CalcAmplitude(pwOld, pw, t, millis()-timestamp);
    vTemp= (v==vOld) ? v : CalcAmplitude(vOld, v, t, millis()-timestamp);
    if(t+timestamp<millis()){ //Verify last step completed
      timestamp=millis();
      String message="Verify:" + String(timestamp);
      webSocket.sendTXT(WSnum, message);
      newdata = false;
    }  
  }
unsigned long currentMillis = millis();
//Modulation
if(MState){ //if mod on test for duty cycle over
  if (currentMillis-CM >= mfTemp*mdTemp/256){
    MState = false;
  }
}else{  //if mod off test for remainder of duty cycle
  if (currentMillis-CM >= mfTemp){
    CM = currentMillis;
    MState = true;
  }
}
if(mfTemp>10000){
  MState=true;
}

if (mfTemp == 0){
  MState = false;
}
//Frequency
unsigned long currentMicros = micros();
if (currentMicros-CF >= pfTemp){
  CF = currentMicros;
  //Frequency should be turned off by PulseWidth so only need to turn it on
  FState = true;
  //set new CurrentPulseWidth start time
  CPW = currentMicros;
}
if (currentMicros-CPW >= pwTemp){
  //PulseWidth should be turned on by Frequency so only need to turn off
  FState = false;
 }

if (FState && MState && !tensState){
  digitalWrite(tens, HIGH);
  tensState=1;
  
}
if(!FState && MState && tensState){
  digitalWrite(tens, LOW);
  tensState=0;
  
}
if(!MState && tensState){
  digitalWrite(tens, LOW);
  tensState=0;
  
  }
Voltlimit=vTemp;
} 
}
  

 void smpscontrol(){
  int Limit=0;
  if(millis()>(smpsMillis+20)){    
  smpsMillis=millis();  //allow some time for a few pulses to pass at approx 1kHz
  VoltRead=analogRead(smpsOutV);
  Limit=map(Voltlimit, 0, 255, 0, MaxVolts); //map voltlimit to maxvolts
  //if(Voltlimit>MaxVolts){Limit=MaxVolts;}else{Limit=Voltlimit;} //limit voltlimit to maxvolts
  if(VoltRead < Limit){
    if(PWMOut<50){PWMOut++;}
  }else if(VoltRead > Limit){
    if(PWMOut>0){PWMOut--;}
  }else if(VoltRead > (Limit+10)){
    PWMOut=0;
    Serial.println("Voltage too high!");
  }
  sigmaDeltaWrite(0,PWMOut);
  }
}

unsigned int CalcAmplitude(unsigned int Old,unsigned int New, long TotalTime, long CurrentTime){
  int A = Old-New;
  double Value = New + (A/2)*(1 + cos(TotalTime*M_PI/CurrentTime));
  return Value;
}
/*End main program Functions*/


/*Start of Web Server response's*/
void handleRoot() {
  
  char temp[800];
  int sec = millis() / 1000;
  int mins = sec / 60;
  int hr = mins / 60;
  int ssi = WiFi.RSSI();
  snprintf ( temp, 800,

"<html>\
  <head>\
    <meta http-equiv='refresh' content='20'/>\
    <title>ESP8266 Demo</title>\
    <style>\
      body { color:white;position:absolute;width:100%;height:100%;background-size:cover;background-image:url('http://www.entertheblayr.com/ssl/frost/img/Backgrounds/espdefault.jpg'); }\
    </style>\
  </head>\
  <body>\
    <div id='bg'>\
    <h1>Hello from your Mistress!</h1>\
    <p>Uptime: %02d:%02d:%02d</p>\
    <p>TENS Voltage: %i </p>\
    <p>WiFi Signal Strength: %d </p>\
    </div>\
  </body>\
</html>",

    hr, mins % 60, sec % 60, VoltRead*4/10, ssi
  );
  server.send ( 200, "text/html", temp );
  
}

void handleNotFound() {
  
  String message = "File Not Found\n\n";
  message += "URI: ";
  message += server.uri();
  message += "\nMethod: ";
  message += ( server.method() == HTTP_GET ) ? "GET" : "POST";
  message += "\nArguments: ";
  message += server.args();
  message += "\n";

  for ( uint8_t i = 0; i < server.args(); i++ ) {
    message += " " + server.argName ( i ) + ": " + server.arg ( i ) + "\n";
  }
  Serial.print (message);
  server.send ( 404, "text/plain", message );
  
}

void s2on() {
  digitalWrite (sqz, LOW);
  server.send (200, "text/plain", "S2:ON");
}

void s2off() {
  digitalWrite (sqz, HIGH);
  server.send (200, "text/plain", "S2:OFF"); 
}
void sqzon() {
  digitalWrite (sqz, LOW);
  server.send (200, "text/plain", "SQZ:ON");
}

void sqzoff() {
  digitalWrite (sqz, HIGH);
  server.send (200, "text/plain", "SQZ:OFF"); 
}

void vacon() {
  String text = "VAC:ON";
  digitalWrite (vac, LOW);
  server.send (200, "text/plain", text);
}

void vacoff(){
  digitalWrite (vac, HIGH);
  server.send (200, "text/plain", "VAC:OFF");
}

void pumpon() {
  String text = "PUMP:ON";
  digitalWrite (pum, LOW);
  server.send (200, "text/plain", text);
}

void pumpoff(){
  digitalWrite (pum, HIGH);
  server.send (200, "text/plain", "PUMP:OFF");
}

void servo1(){
  int pos;
  if (server.arg(0)){
  pos = server.arg(0).toInt();
  String text = "SERVO1:";
  text += pos;
  server.send(200, "text/plain", text);
 } else {
  server.send (400, "text/plain", "No position argument sent");
 }
 sv1.write(pos);
}
void sv1loop(int pos){
  sv1.write(pos);
}

void tenssetmaxvolts(){
   int pos;
  if (server.arg(0)){
  pos = server.arg(0).toInt();
  MaxVolts=pos;
  pos=pos*4/10;
  String text = "SMPS Max:";
  text += pos;
  server.send(200, "text/plain", text);
 } else {
  server.send (400, "text/plain", "No voltage argument sent");
 }
 Serial.print("Max Volts set to:");
 Serial.println(MaxVolts);
}

void tenson(){
 if (server.arg(0)){
  tensMF = server.arg(0).toInt() * 40 ;//modulation period in ms
  
 } else {
  server.send (400, "text/plain", "No modulation argument sent");
 }
 if (server.arg(1)){
  tensF = 1000000 /(pow(1.034, server.arg(1).toInt()));// period in us
 } else {
  server.send (400, "text/plain", "No frequency argument sent");
 }
 if (server.arg(2)){
  tensPW = server.arg(2).toInt()*2 ;//pulse length in us
 } else {
  server.send (400, "text/plain", "No Pulse Width argument sent");
 }
 if (server.arg(3)){
  Voltlimit = server.arg(3).toInt() ;//Voltage in .2V steps
  } else {
  server.send (400, "text/plain", "No Voltage argument sent");
 } 
 if (tensMF == 0){
     server.send (200, "text/plain", "TENS:OFF");
  }else{
     server.send(200, "text/plain", "TENS:ON");
  }
}

void tensoff(){
 tensMF = 0; 
  server.send (200, "text/plain", "TENS:OFF");
 }
