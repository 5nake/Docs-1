{Auth} = App.Models
{View} = App.View
{Popup} = App.Models
{AbstractController} = App.Controllers
{DocsController} = App.Controllers

namespace App:Controllers:
  class AuthController extends AbstractController
    nd.controller(@)

    view: 'auth'

    constructor: (dom) ->
      super dom

      Auth::login =>
        @doLogin()

    doLogin: =>
      App.Controllers.DocsController::load()

    auth: (i, e) =>
      new Popup(e.currentTarget.getAttribute('data-url'))
      return false





