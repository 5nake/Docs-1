{Xml}  = Raid.Converter
{Json} = Raid.Converter

namespace Raid:Request:
  class Request
    STATE_UNSENT            = 0
    STATE_OPENED            = 1
    STATE_HEADERS_RECEIVED  = 2
    STATE_LOADING           = 3
    STATE_READY             = 4

    TYPE_JSON               = 'application/json'
    TYPE_XML                = 'text/html'


    request = $private 'request'
    events  = $private 'events'

    constructor: ->
      @raw          = false
      @[events]     = {
        progress: []
      }
      @url          = ''
      @async        = true

    progress: (cb) ->
      @[events].progress.push cb
      @

    get: (url, args = {}, cb = (->)) ->
      @request 'GET', url, args, cb
      @

    post: (url, args = {}, cb = (->)) ->
      @request 'POST', url, args, cb
      @

    put: (url, args = {}, cb = (->)) ->
      @request 'PUT', url, args, cb
      @

    delete: (url, args = {}, cb = (->)) ->
      @request 'DELETE', url, args, cb
      @

    head: (url, args = {}, cb = (->)) ->
      @request 'HEAD', url, args, cb
      @

    request: (method, url, args = {}, cb = (->)) =>
      @[request] = new XMLHttpRequest()

      @[request].upload.onprogress = (event) =>
        i(event) for i in @[events].progress

      @[request].onreadystatechange = (d) =>
        type = @[request].getResponseHeader('Content-Type')
        data = @[request].responseText
        if @[request].readyState is STATE_READY
          cb @parse(data, type), @[request].status

      @[request].open method, (@url + url), @async

      unless @raw
        @[request].setRequestHeader "Content-type", "application/x-www-form-urlencoded"
        data = []
        for key, val of args
          data.push encodeURIComponent(key) + '=' + encodeURIComponent(val)
        @[request].send(data.join('&'))
        return @
      @raw = false
      @[request].send(args)
      @


    parse: (data, type) ->
      switch type
        when TYPE_JSON then Json::toData data
        when TYPE_XML then Xml::toData data
        else data
