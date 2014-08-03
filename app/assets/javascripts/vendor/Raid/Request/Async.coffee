namespace Raid:Request:
  class Async extends Raid.Request.Request
    constructor: ->
      super
      @async = true
