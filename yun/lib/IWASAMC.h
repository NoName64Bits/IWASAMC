#ifndef IWASAMC_H
#define IWASAMC_H

#include <Arduino.h>
#include "Bridge.h"
#include "Process.h"

class WANController{
  public:
    WANController();
    void set(String device, String value);
    int get(String device);

  private:

};

class LANController{
  public:
    LANController();
    void set(String device, String value);
    int get(const char* device);

  private:

};

#endif
