var serializer = new function() {
  MessageBroker.subscribe("serializer.store", store);
  MessageBroker.subscribe("serializer.load", load);
  this.pack = pack;
  this.unpack = unpack;

  function pack() {
    MessageBroker.broadcast("serializer.pack",{});
  }

  function unpack() {
    MessageBroker.broadcast("serializer.preunpack",{});
    MessageBroker.broadcast("serializer.unpack",{});
  }

  function store(where, what, from) {
      localStorage[what.name] = JSON.stringify(what.store);
  }

  function load(where, what, from) {
    var value = localStorage[what.name];
    if (value) {
      from(JSON.parse(value));
    }
    else {
      from(null);
    }
  }
}();
