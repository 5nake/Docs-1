{Nav} = App.Models
{User} = App.Models
{Upload} = App.Models
{Search} = App.Models
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

      # Collections
      @search    = new Search(Document.all)
      @documents = @search.found
      @selected  = ko.observableArray []

      # Filters
      @search.matchBy('title')
      @dict      = (dict) => @search.value(dict.value)



      # Document ready subscribe
      Document.ready.subscribe (state) =>
        @search.set(Document.all())

      # Header buttons
      @button = {
        uploads:  new Toggle
        selected: new Toggle
      }
      @button.uploads.visible.subscribe (visible) => @button.selected.visible(false) if visible
      @button.selected.visible.subscribe (visible) => @button.uploads.visible(false) if visible

      # On created
      Document.created (document) =>
        if document.checked()
          @selected.remove (i) -> i.hash is document.hash
          @selected.push document

        document.checked.subscribe (checked) =>
          if checked
            @button.selected.visible true
            @selected.push document
          else
            @selected.remove (i) -> i.hash is document.hash


      # Uploader
      @uploader       = new Upload
      @uploader.files.subscribe =>
        Document.reload()
        @button.uploads.visible(true)

        unless @uploader.files().length
          clearTimeout(@timeout) if @timeout?
          @timeout = setTimeout =>
            @button.uploads.visible(false)
          , 1000

      # Drop Zone
      @dropzoneState  = ko.observable ''
      @createDropzone 'uploadSection'

      # Left Main Nav
      nav     = new Nav.Main()
      nav.buttons()[0].focus()
      @nav    = nav.buttons

      # Left filters
      filter  = new Nav.Filter()
      @filter = filter.buttons

      # Do loading
      Document.load()


    clearSelected: =>
      Document.all().map (item) -> item.checked false

      @button.selected.visible false

    createDropzone: (dataId) =>
      for section in @section(dataId)
        dropzone = new Dropzone(section)

        dropzone.focused.subscribe (state) =>
          @dropzoneState if state then 'upload-hover' else ''

        dropzone.onDrop (event, file) =>
          @uploader.add file



