var serializer = new function() {
  MessageBroker.subscribe("serializer.store", store);
  MessageBroker.subscribe("serializer.load", load);
  MessageBroker.subscribe("serializer.clear", clear);
  MessageBroker.subscribe("serializer.boot", boot);
  MessageBroker.subscribe("serializer.save", save);

  function save() {
    MessageBroker.broadcast("serializer.pack",{});
  }

  function boot() {
    MessageBroker.broadcast("serializer.preunpack",{});
    MessageBroker.broadcast("serializer.unpack",{});
  }

  function store(where, what, from) {
      localStorage[what.name] = JSON.stringify(what.store);
  }

  function clear() {
      for (var key in localStorage) {
        delete localStorage[key];
      }
  }

  function load(where, what, from) {
    var value = localStorage[what];
    if (value) {
      from(JSON.parse(value));
    }
    else {
      from(null);
    }
  }
}();
