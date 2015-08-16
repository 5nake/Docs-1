{View} = App.View

namespace App:Controllers:
  class AbstractController
    view: 'abstract'

    constructor: (@dom) ->

    load: (callback) =>
      view = new View(@view, config.env isnt 'local')
      view.get (view) =>
        if callback?
          callback(view)
        else
          view.setTo(document.getElementById('master'))
          nd.applyBindings()

    section: (dataId) =>
      @dom.querySelectorAll "[data-id=#{dataId}]"