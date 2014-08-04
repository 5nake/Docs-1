{Async} = Raid.Request

namespace global:
  class HeaderController
    constructor: ->
      @volume = ko.observable 0
      @maxVolume = ko.observable 100000
