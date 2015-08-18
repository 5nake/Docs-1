{Xml}  = App.Support.Converter
{Json} = App.Support.Converter

namespace App:Request:
  class Ajax
    define AJAX_UNSENT:   0
    define AJAX_OPENED:   1
    define AJAX_HEADERS_RECEIVED: 2
    define AJAX_LOADING:  3
    define AJAX_READY:    4

    define METHOD_GET:    'GET'
    define METHOD_POST:   'POST'
    define METHOD_PUT:    'PUT'
    define METHOD_DELETE: 'DELETE'
    define METHOD_HEAD:   'HEAD'

    define HEADER_JSON:   'application/json'
    define HEADER_HTML:   'text/html'
    define HEADER_XML:    'text/xml'
    define HEADER_MPT:    'application/x-www-form-urlencode'

    options = $private 'options'

    subscribers = []

    @subscribe: (cb) =>
      subscribers.push cb
      @

    constructor: ->
      do @resetOptions

    resetOptions: ->
      @[options] = {
        url:        ''
        multipart:  false
        method:     METHOD_GET
        async:      true
        header:     HEADER_MPT
        parse:      true
      }
      @

    with: (args = {}) ->
      for opt, value of args
        @[options][opt] = value
      @

    request: (url, args = {}, cb = (->)) ->
      if typeof args is 'function'
        [cb, args] = [args, {}]

      xhr = new XMLHttpRequest()

      #xhr.upload.onprogress = (event) =>

      xhr.onreadystatechange = (event) =>
        type = xhr.getResponseHeader('Content-Type')
        data = xhr.responseText

        if xhr.readyState is AJAX_READY
          output = @parse(data, type);
          for subscriber in subscribers
            subscriber(output, xhr.status)
          cb(output, xhr.status)

      xhr.open @[options].method, @[options].url + url, @[options].async
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
      xhr.setRequestHeader 'X-CSRF-TOKEN', config.csrf

      if @[options].multipart
        xhr.send args
      else
        #xhr.setRequestHeader('Content-type', @[options].header)
        data = []
        for key, val of args
          data.push encodeURIComponent(key) + '=' + encodeURIComponent(val)
        xhr.send data.join('&')

      do @resetOptions




    parse: (data, type) ->
      if @[options].parse
        switch type.split(';')[0]
          when HEADER_JSON then return Json::toData data
          when HEADER_XML  then return Xml::toData data
          else data
      return data
