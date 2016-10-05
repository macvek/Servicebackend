var uptime = new function() {
    MessageBroker.subscribe("appstart", boot);
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
            url:"uptime.php",
            success:function(uptimeResp) {
                updateContent(JSON.parse(uptimeResp).uptime);
                MessageBroker.send("global.pluginupdate", {pluginbox:$(".plugin-uptime")});
            }
        });
    }

    function updateContent(content) {
        $(".plugin-uptime > .pluginbox-content").text(content);
    }

    function onRefreshRate(what, refreshRate) {
        if (!refreshRate) { return ; }
        refreshAt(refreshRate);
    }

    function boot() {
        refresh();  
    }
}();