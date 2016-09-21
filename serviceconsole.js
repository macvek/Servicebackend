var serviceconsole = new function() {
    var autoscroll = true;

    function write(what, param, from) {
        var msgItem = $("<div>").text(param);
        var display = loadDisplay();
        display.append(msgItem);
        var destColor = display.css("color");
        msgItem.css({color:"#fff"});
        msgItem.animate({color:destColor}, 1000);
        if (autoscroll) {
            display.scrollTop(10e10);
        }
    }

    function appstart() {
        $(".plugin-console .clear-console").click(function() {
            MessageBroker.send("serviceconsole.clear");
        });
    }

    function clear() {
        loadDisplay().empty();
    }


    function loadDisplay() {
        return $(".plugin-console > .pluginbox-content");
    }

    function setAutoscroll(what, val) {
        autoscroll = val;
    }

    MessageBroker.subscribe("serviceconsole.write", write);
    MessageBroker.subscribe("serviceconsole.clear", clear);
    MessageBroker.subscribe("serviceconsole.autoscroll", setAutoscroll);
    MessageBroker.subscribe("appstart", appstart);
}