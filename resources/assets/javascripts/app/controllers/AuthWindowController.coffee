{Auth} = App.Models

namespace App:Controllers:
  class AuthWindowController
    nd.controller @

    constructor: ->
      Auth::loginByData(auth.user)

      @errors = ko.observableArray auth.errors

      @user   = Auth::user()
      @ready  = ko.observable(false)

      setTimeout((=> @ready(true)), 100)
      setTimeout((=> window.close()), 1000)
