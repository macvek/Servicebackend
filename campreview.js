var campreview = new function() {
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
        $(".plugin-campreview .pluginbox-content").css({
            "background-image":"url(campreview.php?q="+Math.random()+")"
        });

        MessageBroker.send("global.pluginupdate", {pluginbox:$(".plugin-campreview")});
    }

    function onRefreshRate(what, refreshRate) {
        if (!refreshRate) { return ; }
        refreshAt(refreshRate);
    }

    function boot() {
        refresh();  
    }
}();
