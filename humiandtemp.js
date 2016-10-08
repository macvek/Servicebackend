var humiandtemp = new function() {
    MessageBroker.subscribe("global.refreshrate", onRefreshRate);
    var interval;

    function refreshAt(delayInSec) {
        if (interval) {
            clearInterval(interval);
        }
        interval = setInterval(refresh,delayInSec*1000);
    }

    function refresh() {
        $.ajax({
            url:"humiandtemp.php",
            success:function(uptimeResp) {
                updateContent(JSON.parse(uptimeResp));
                MessageBroker.send("global.pluginupdate", {pluginbox:$(".plugin-humiandtemp")});
            }
        });
    }

    function updateContent(content) {
        $plugin = $(".plugin-humiandtemp > .pluginbox-content");
        if (content.error) {
            MessageBroker.send("serviceconsole.write","Error humiandtemp: "+content.error);
        }
        else {
            $(".temperature", $plugin).text(content.temperature+" °C");
            $(".humidity", $plugin).text(content.humidity+" %");
            $(".date", $plugin).text(content.date);
            if (!content.checksum) {
                MessageBroker.send("serviceconsole.write","Checksum error - humiandtemp");
            }
        }
    }

    function onRefreshRate(what, refreshRate) {
        if (!refreshRate) { return ; }
        refreshAt(refreshRate);
    }

    function boot() {
        refresh();  
    }
}();