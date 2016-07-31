<?php
  $data_now = explode(",", file_get_contents("data.now"));
  $id = $data_now[0];
  $light = $data_now[1];
  $light_sensor = $data_now[2];
  $temp_sensor = $data_now[3];
  $humidity_sensor = $data_now[4];
  $fan = $data_now[5];

  if(isset($_GET['set'])){
    if($id > 500000){
      file_put_contents("data.history", "");
      $id = 0;
    } else {
      file_put_contents("data.history", file_get_contents("data.history") . $id . "," .
        $light . "," . $light_sensor . "," . $temp_sensor . "," . $humidity_sensor . "," . $fan);
    }

    if(isset($_GET['light'])){
      if(isset($_GET['toggle'])){
        if($light == "0")
          $light = "1";
        else if($light == "1")
          $light = "0";
      } else {
        $light = $_GET['light'];
      }
    }

    if(isset($_GET['light_sensor'])){
      $light_sensor = $_GET['light_sensor'];
    }

    if(isset($_GET['temp_sensor'])){
      $temp_sensor = $_GET['temp_sensor'];
    }

    if(isset($_GET['humidity_sensor'])){
      $humidity_sensor = $_GET['humidity_sensor'];
    }

    if(isset($_GET['fan'])){
      $fan = $_GET['fan'];
    }

    $id++;

    file_put_contents("data.now", $id . "," . $light . "," . $light_sensor .
        "," . $temp_sensor . "," . $humidity_sensor . "," . $fan);

    if(!isset($_GET['silence'])){
      echo "OK! Action completed successfully!";
    }
  } else if(isset($_GET['get'])){
    if(isset($_GET['light'])){
      if(isset($_GET['silent'])){
        echo $light;
      } else {
        if($light == "0"){
          echo "The light is turned off.";
        } else {
          echo "The light is turned on.";
        }
      }
    } elseif(isset($_GET['light_sensor'])){
      if(isset($_GET['silent'])){
        echo $light_sensor;
      } else {
        echo "Ambient light is at a level of " . $light_sensor . " percents.";
      }
    } elseif(isset($_GET['temp_sensor'])) {
      if(isset($_GET['silent'])){
        echo $temp_sensor;
      } else {
        echo "Room temperature is at about " . $temp_sensor . " degrees Celsius.";
      }
    } elseif(isset($_GET['humidity_sensor'])) {
      if(isset($_GET['silent'])){
        echo $humidity_sensor;
      } else {
        echo "Room humidity is at a level of " . $humidity_sensor . " percents.";
      }
    }elseif(isset($_GET['fan'])) {
        echo $fan;
    }
  } else if(isset($_GET['log'])){
    $write = "[" . date("d/m/y h:i:s a") . "] " . $_GET['in'] . " -> " . $_GET['out'];

    if(isset($_GET['json'])){
      file_put_contents("json.log", $write);
    } elseif (isset($_GET['plain'])) {
      file_put_contents("activity.log", $write);
    }
  }
?>
