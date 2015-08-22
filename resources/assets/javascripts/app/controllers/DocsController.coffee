{Nav} = App.Models
{User} = App.Models
{Upload} = App.Models
{Toggle} = App.Models
{Document} = App.Models
{Dropzone} = App.Models.Upload
{AbstractController} = App.Controllers

namespace App:Controllers:
  class DocsController extends AbstractController
    nd.controller(@)
    view: 'docs'

    constructor: (dom) ->
      super dom

      @documents = Document.all
      Document::load()

      @buttonUploads  = new Toggle

      @uploader       = new Upload
      @uploader.files.subscribe =>
        Document::reload()
        @buttonUploads.visible(true)

        unless @uploader.files().length
          clearTimeout(@timeout) if @timeout?
          @timeout = setTimeout =>
            @buttonUploads.visible(false)
          , 1000

      @dropzoneState  = ko.observable ''
      @createDropzone 'uploadSection'



      nav     = new Nav.Main()
      nav.buttons()[0].focus()
      @nav    = nav.buttons

      filter  = new Nav.Filter()
      @filter = filter.buttons

    createDropzone: (dataId) =>
      for section in @section(dataId)
        dropzone = new Dropzone(section)

        dropzone.focused.subscribe (state) =>
          @dropzoneState if state then 'upload-hover' else ''

        dropzone.onDrop (event, file) =>
          @uploader.add file



