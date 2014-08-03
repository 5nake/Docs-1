namespace Raid:Request:
  class Sync extends Raid.Request.Request
    constructor: ->
      super
      @async = false
