#include <IWASAMC.h>

#define LIGHT 2
#define FAN 3

int pins[4] = {4, 7, 6, 5};

// LANController lan;
// - get(device)
// - set(device, value)

WANController wan;
// - get(device)
// - set(device, value)

void setup() {
  initDevices();
}

void loop() {
  setDevice(LIGHT, wan.get("light") == 0 ? false : true);
  setDevice(FAN, wan.get("fan") == 0 ? false : true);
}

void initDevices() {
  pinMode(pins[FAN], OUTPUT);
  pinMode(pins[LIGHT], OUTPUT);

  for (int i = 0; i < 2; i++) {
    pinMode(pins[i], OUTPUT);
    digitalWrite(pins[i], LOW);
  }
}

void setDevice(int index, boolean state){
  digitalWrite(pins[index], state);
}
