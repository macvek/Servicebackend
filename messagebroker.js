var MessageBroker = new function() {
  this.send = send;
  this.subscribe = subscribe;
  this.broadcast = broadcast;

  var receivers = {};

  function subscribe(where, receiver) {
    if ("function" !== typeof receiver) {
      console.error("receiver is not a function: "+where);
      return;
    }

    if (!receivers[where]) {
      receivers[where] = [];
    }
    receivers[where].push(receiver);
  }

  function broadcast(where, what, from) {
    console.trace("[ BROADCAST ] ",where,what,from);
    if (!receivers[where]) {
      return;
    }
    sendMessage(where,what,from);
  }

  function send(where, what, from) {
    if (!receivers[where]) {
      console.error("Unknown receiver: "+where);
      return;
    }
    console.trace("[ SEND ] ",where,what,from);
    sendMessage(where,what,from);
  }

  function sendMessage(where,what,from) {
    var list = receivers[where];
    var encFrom = encapsulateFrom(where, from);
    for (var i=0;i<list.length;i++) {
      list[i](where,what,encFrom);
    }
  }

  function encapsulateFrom(where, from) {
    return from ? traceOnCall(where, from) : warnOnCall(where);
  }

  function traceOnCall(where, from) {
    return function(param) {
      console.trace("Return Call ",where, param);
      from(param);
    }
  }

  function warnOnCall(where) {
    return function(param) {
      console.warn("invoked not supported call ", where, param);
    }
  }
}();
