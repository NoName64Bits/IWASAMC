var intentType = { payload : msg.payload.request.type };

switch(msg.payload.request.type){
    case "LaunchRequest": return launch();
    case "IntentRequest": return intent();
    case "SessionEndedRequest": return end();
}

function launch(){
    msg.payload = "Welcome to your room! You can ask me to toggle something " +
                "or to give you information about environment!";
    return [null, null, msg];
}

function intent(){
    var reqest = "";

    if(msg.payload.request.intent.name == "SetIntent"){
        request = "set&";
        switch(msg.payload.request.intent.slots.Device.value){
            case "lights": request += "light="; break;
        }
        switch(msg.payload.request.intent.slots.State.value){
            case "on": request += "1"; break;
            case "off": request += "0"; break;
        }
    } else if(msg.payload.request.intent.name == "GetIntent"){
        request = "get&";
        switch(msg.payload.request.intent.slots.Input.value){
            case "ambient light": request += "light_sensor"; break;
            case "temperature": request += "temp_sensor"; break;
            case "humidity": request += "humidity_sensor"; break;
            case "light": request += "light"; break;
        }
    } else if(msg.payload.request.intent.name == "ToggleIntent"){
        request = "set&";
        switch(msg.payload.request.intent.slots.Device.value){
            case "lights": request += "light&"; break;
        }
        request += "toggle";
    }

    msg.req = request;
    return [msg, null, null];
}

function end(){
    return [null, null, null];
}
