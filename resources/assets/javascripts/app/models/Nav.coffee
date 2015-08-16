namespace App:Models:
  class Nav
    class @Button
      id =    0
      group:  ko.observableArray([])

      constructor: (title, icon) ->
        @callbacks = []

        @id     = "button-#{id++}"
        @title  = ko.observable title
        @icon   = ko.observable icon
        @active = ko.observable(false)


      click: (callback) =>
        @callbacks.push callback
        @

      focus: =>
        i(this) for i in @callbacks
        false


    constructor: ->
      @callbacks = []
      @buttons   = ko.observableArray([])

    click: (callback) =>
      @callbacks.push callback
      @

    addButton: (button) =>
      @buttons.push(button)
      #button.group = @buttons
      button.click (ctx) =>
        cb(ctx) for cb in @callbacks
