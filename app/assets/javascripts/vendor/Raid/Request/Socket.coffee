{Json} = Raid.Converter

namespace Raid:Request:
  class Socket
    events      = $private 'events'
    connection  = $private 'connection'
    requestId   = $private 'requestId'
    @::[requestId] = 0

    constructor: (@host = '127.0.0.1', @port = '8080') ->
      self = @

      @[events] =
        open:     []
        close:    []
        message:  []
        send:     []

      @[events].call = (name, data) =>
        for i in @[events][name]
          (data = res) if (res = i(data))?
        return data


      @['on'] =
        open:     (cb) => self.onOpen cb
        close:    (cb) => self.onClose cb
        message:  (cb) => self.onMessage cb
        send:     (cb) => self.onSend cb

    onOpen: (cb) ->
      @[events].open.push cb

    onClose: (cb) ->
      @[events].close.push cb

    onMessage: (cb) ->
      @[events].message.push cb

    onSend: (cb) ->
      @[events].send.push cb

    call: (method, args) ->
      @send {
        id: (++@[requestId]),
        method: method,
        data: args,
      }

    send: (msg) ->
      msg = @[events].call 'send', msg
      if typeof msg is 'object'
        @[connection].send Json::toString msg
      else
        @[connection].send msg

    connect: ->
      @[connection] = new WebSocket "ws://#{@host}:#{@port}"
      @[connection].onopen    = (e) => @[events].call 'open', e
      @[connection].onmessage = (e) => @[events].call 'message', Json::toData e.data
      @[connection].onclose   = (e) => @[events].call 'close', e
