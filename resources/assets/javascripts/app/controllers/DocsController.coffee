{Nav} = App.Models
{User} = App.Models
{Upload} = App.Models
{Document} = App.Models
{Dropzone} = App.Models.Upload
{AbstractController} = App.Controllers

namespace App:Controllers:
  class DocsController extends AbstractController
    nd.controller(@)
    view: 'docs'

    constructor: (dom) ->
      super dom

      @uploader = new Upload

      @dropzoneState = ko.observable ''
      for section in @section('uploadSection')
        dropzone = new Dropzone(section)
        dropzone.focused.subscribe (state) =>
          @dropzoneState if state then 'upload-hover' else ''


      @documents = Document.all
      Document::load()


      nav     = new Nav.Main()
      nav.buttons()[0].focus()
      @nav    = nav.buttons

      filter  = new Nav.Filter()
      @filter = filter.buttons



