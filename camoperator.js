var camoperator = new function() {
    MessageBroker.subscribe("camoperator.on", turnOn);
    MessageBroker.subscribe("camoperator.off", turnOff);

    function turnOn() {
        sendSignal("on");
    }

    function turnOff() {
        sendSignal("off");
    }

    function sendSignal(msg) {
        $.ajax({
            method:'POST',
            url:"camoperator.php",
            data:{'operation':msg}
        });
    }

}();