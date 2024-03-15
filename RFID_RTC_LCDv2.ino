#include <SPI.h>
#include <MFRC522.h>
#include <LiquidCrystal_I2C.h>
#include <Wire.h>
#include "RTClib.h"



RTC_DS1307 RTC;

/*
byte D[8] = {
	0b01110,
	0b01010,
	0b01010,
	0b01010,
	0b11111,
	0b10001,
	0b10001,
	0b00000
};
byte U[8] = {
	0b11000,
	0b01000,
	0b01000,
	0b01111,
	0b01001,
	0b01001,
	0b01111,
	0b00000
};
byte P[8] = {
	0b11111,
	0b10001,
	0b10001,
	0b10001,
	0b10001,
	0b10001,
	0b10001,
	0b00000
};
byte Z[8] = {
	0b11111,
	0b00001,
	0b00001,
	0b01111,
	0b00001,
	0b00001,
	0b11111,
	0b00000
};
byte SH[8] = {
	0b10101,
	0b10101,
	0b10101,
	0b10101,
	0b10101,
	0b10101,
	0b11111,
	0b00000
};
//БГ букви
*/
#define gr_pin 8
#define red_pin 7 

#define SS_PIN 10
#define RST_PIN 9
MFRC522 mfrc522(SS_PIN, RST_PIN);   // Create MFRC522 instance.

LiquidCrystal_I2C lcd(0x27, 16, 2);

void setup() 
{
  Serial.begin(9600);   // Initiate a serial communication
  SPI.begin();      // Initiate  SPI bus
  mfrc522.PCD_Init();   // Initiate MFRC522
  Serial.println("Approximate your card to the reader...");
  Serial.println();
  pinMode(gr_pin, OUTPUT);
  pinMode(red_pin, OUTPUT);
  lcd.begin();
  lcd.backlight();

  RTC.begin(); // load the time from your computer.

if (! RTC.isrunning())

{

Serial.println("RTC is NOT running!");// This will reflect the time that your sketch was compiled

RTC.adjust(DateTime(__DATE__, __TIME__));
  

  /*
  lcd.createChar(0, Z);
  lcd.createChar(1, D);
  lcd.createChar(2, U);
  lcd.createChar(3, P);
  lcd.createChar(4, SH);
  */
}
}
void loop() 
{
  lcd.clear();
  DateTime now = RTC.now();
  // Look for new cards
  if ( ! mfrc522.PICC_IsNewCardPresent()) 
  {
    return;
  }
  // Select one of the cards
  if ( ! mfrc522.PICC_ReadCardSerial()) 
  {
    return;
  }
  //Show UID on serial monitor
  Serial.print("UID tag :");
  String content= "";
  byte letter;
  for (byte i = 0; i < mfrc522.uid.size; i++) 
  {
     Serial.print(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " ");
     Serial.print(mfrc522.uid.uidByte[i], HEX);
     content.concat(String(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " "));
     content.concat(String(mfrc522.uid.uidByte[i], HEX));
  }
  Serial.println();
  Serial.print("Message : ");
  content.toUpperCase();
  if (content.substring(1) == "86 17 D6 48" || content.substring(1) == "45 18 41 C5") //change here the UID of the card/cards that you want to give access
  {
    Serial.println("Authorized access");
    Serial.println();
    digitalWrite(gr_pin, HIGH);
    lcd.print("Checked in");
    cycle();
  /*  
    lcd.setCursor(0, 0);
    lcd.print("PA");
    lcd.setCursor(2, 0);
    lcd.write(byte(0));
    lcd.setCursor(3, 0);
    lcd.print("PE");
    lcd.setCursor(5, 0);
    lcd.write(byte(4));
    lcd.setCursor(6, 0);
    lcd.print("EH");
    lcd.setCursor(9, 0);
    lcd.write(byte(1));
    lcd.setCursor(10, 0);
    lcd.print("OCT");
    lcd.setCursor(13, 0);
    lcd.write(byte(2));
    lcd.setCursor(14, 0);
    lcd.write(byte(3));
  */
    
    delay(5000);
    lcd.clear();
    digitalWrite(gr_pin, LOW);
  }
 
 else   {
    Serial.println("Access denied");
    digitalWrite(red_pin, HIGH);
    lcd.print(" Try again");
    cycle();
/*
    lcd.setCursor(0, 0);
    lcd.write(byte(1));
    lcd.setCursor(1, 0);
    lcd.print("OCT");
    lcd.setCursor(4, 0);
    lcd.write(byte(2));
    lcd.setCursor(5, 0);
    lcd.write(byte(3));
    lcd.setCursor(7, 0);
    lcd.print("OTKA");
    lcd.setCursor(11, 0);
    lcd.write(byte(0));
    lcd.setCursor(12, 0);
    lcd.print("AH");
*/

    delay(5000);
    digitalWrite(red_pin, LOW);
    lcd.clear();
    
      }
  
} 
void cycle(){
  DateTime now = RTC.now();
lcd.setCursor(0, 1);
lcd.print(now.month(), DEC);

lcd.print('/');

lcd.print(now.day(), DEC);

lcd.print(' ');

lcd.print(now.hour(), DEC);
Serial.print(now.hour(), DEC);
lcd.print(':');
Serial.print(":");
lcd.print(now.minute(), DEC);
Serial.print(now.minute(), DEC);
lcd.print(':');
Serial.print(":");
lcd.print(now.second(), DEC);
Serial.print(now.second(), DEC);
uint16_t year = now.year();
uint8_t month = now.month();
uint8_t day = now.day();
Serial.print(" ");
switch(weekday(year,month,day)){
     case 1:
     lcd.print("Mon");
     break;
     case 2:
     lcd.print("Tue");
     break;
     case 3:
     lcd.print("Wed");
     break;
     case 4:
     lcd.print("Thu");
     break;
     case 5:
     lcd.print("Fri");
     break;
     case 6:
     lcd.print("Sat");
     break;
     case 7:
     lcd.print("Sun");
     
     break;
     default: lcd.print("Day error!"); break;
     }
     


}
int weekday(int year,int month,int day)
/* Calculate day of week in proleptic Gregorian calendar. Sunday == 0. */
{
  int adjustment, mm, yy;
  if (year<2000) year+=2000;
  adjustment = (14 - month) / 12;
  mm = month + 12 * adjustment - 2;
  yy = year - adjustment;
  return (day + (13 * mm - 1) / 5 +
    yy + yy / 4 - yy / 100 + yy / 400) % 7;
}  
