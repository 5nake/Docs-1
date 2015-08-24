{Cache} = App.Cache
{Ajax} = App.Request

namespace App:Model:
  class Model
    @route:      'docs.all'
    @method:     METHOD_GET
    @all:        ko.observableArray([])
    @ready:      ko.observable false
    # events
    @onCreated:  []
    @onCreating: []

    @created: (callback) ->
      @onCreated.push callback
      @

    @creating: (callback) ->
      @onCreating.push callback
      @

    @load: (cb = (->)) ->
      @ready(false)

      xhr = new Ajax
      xhr = xhr.with({ method: @method, parse: false })
      xhr.request route.route(@route), (response) =>
        cb(@)
        for i in response
          event(i) for event in @onCreating
          instance = new @(i)
          @all.push(instance)
          event(instance, i) for event in @onCreated
        @ready(true)

    @reload: ->
      @load => @all []


    # INSTANCE
    constructor: (args) ->
      for i of args
        @[i] = ko.observable args[i]
