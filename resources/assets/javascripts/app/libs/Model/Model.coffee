{Cache} = App.Cache
{Ajax} = App.Request

namespace App:Model:
  class Model
    route:
      name: 'null'
      method: METHOD_GET

    @all   = ko.observableArray([])
    @ready = ko.observable false

    constructor: (args) ->
      for i of args
        @[i] = ko.observable args[i]


    load: (cb = (->)) =>
      $static = @constructor

      $static.ready(false)

      xhr = new Ajax
      xhr = xhr.with({ method: $static::route.method, parse: false })
      xhr.request route.route($static::route.name), (response) =>
        cb($static)
        for i in response
          $static.all.push(new $static(i))
        $static.ready(true)

    reload: =>
      $static = @constructor
      @load => $static.all []
