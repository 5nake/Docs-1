{Ajax}  = App.Request
{Cache} = App.Cache
{Xml}   = App.Support.Converter

namespace App:View:
  class View
    define VIEW_STORAGE_PREFIX: 'view.'

    all = []

    data:
      text: '<div></div>'
      xml: document.createElement('div')

    cache:
      driver: new Cache
      enable: true

    constructor: (@name, enableCache = true) ->
      all.push @
      # Ноды, к которым прикреплена вьюшка
      @appendsTo = []

      @route    = route.action('view', {name: @name, _token: config.csrf})

      @cache.enable = enableCache
      @cache.driver.prefix = VIEW_STORAGE_PREFIX


    all: => all

    get: (callback = ->) =>
      if @cache.enable && @cache.driver.has(@name)
        return Xml::toData(@cache.driver.get(@name))

      @load (response) => callback(response)

    clean = (node) ->
      while (node.firstChild)
        node.removeChild(node.firstChild);
      node.innerHTML = ''

    destroy: =>
      for node in @appendsTo
        clean(node)



    load: (callback = ->) =>
      xhr = new Ajax
      xhr = xhr.with({ method: METHOD_POST, parse: false })
      xhr.request @route, (text) =>
        @cache.driver.put(@name, 60, text)
        @data = {
          text: text
          xml: Xml::toData(text)
        }

        callback(@)

    getXml: =>
      return @data.xml

    getData: =>
      return @data.text

    appendTo: (target) =>
      @appendsTo.push target
      target.appendChild @getXml()
      @

    setTo: (target) =>
      clean(target)
      target.appendChild @getXml()
      @
