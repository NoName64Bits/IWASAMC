#include "IWASAMC.h"

Process p;

WANController::WANController(){
  Bridge.begin();
}

void WANController::set(String device, String value){
  p.runShellCommand("curl -L \"http://www.carabella.ro/server/api?set&" + device + "=" + value + "\"");
  while (p.running());
}

int WANController::get(String device){
  p.runShellCommand("curl -L \"http://www.carabella.ro/server/api?get&" + device + "&silent\"");
 while (p.running());
 if (p.available()) {
   return p.parseInt();
 }

 return -1;
}

LANController::LANController(){
  Bridge.begin();
}

void LANController::set(String device, String value){
  Bridge.put(device, value);
}

char _val[2];

int LANController::get(const char* device){
  Bridge.get(device, _val, 2);
  return atoi(_val);
}
