namespace App:Controllers:Windows:
  class AbstractWindow
    windows       = {}
    window.modal  = (alias) -> windows[alias]

    @register: (alias) ->
      nd.controller @
      @alias = alias

    constructor: ->
      windows[@constructor.alias] = @

      @classAttribute = ko.observable 'window'

      @visible = ko.observable false
      @visible.subscribe (value) =>
        @classAttribute('window' + (if value then ' visible' else ''))

    onShow: (args...) =>
      @

    onHide: (args...) =>
      @

    show: (args...) =>
      @visible true
      @onShow.apply @, args
      @

    hide: (args...) =>
      @onHide.apply @, args
      @visible false
      @
