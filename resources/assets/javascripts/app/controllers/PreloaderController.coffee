{View} = App.View
{Auth} = App.Models
{AuthController} = App.Controllers
{DocsController} = App.Controllers
{AbstractController} = App.Controllers


namespace App:Controllers:
  class PreloaderController extends AbstractController
    nd.controller(@)
    view: 'preloader'

    constructor: (dom) ->
      super dom

      @target  = document.getElementById 'output'
      @visible = ko.observable true

      if Auth::guest()
        AuthController::load (view) => @after(view)
      else
        DocsController::load (view) => @after(view)


    after: (view) =>
      @visible false
      setTimeout =>
        view.setTo document.getElementById('master')
        nd.applyBindings()
      , 600

