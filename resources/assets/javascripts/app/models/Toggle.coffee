namespace App:Models:
  class Toggle
    constructor: ->
      @visible = ko.observable false

    click: =>
      @visible(!@visible())
      false