{Async} = Raid.Request

namespace global:
  class UploaderController
    constructor: ->
      @loaded           = ko.observable 0
      @total            = ko.observable 0
      app('async').progress (e) =>
        @loaded e.loaded
        @total e.total

      @uploadedProgress = ko.observable false
      @uploadedProgress.subscribe (v) =>
        if v
          @loaded 0
          @total 0

      @files            = ko.observableArray []

    remove: (id) ->
      do (id) =>
        @files.remove (i) -> i.id is id


    uploadFiles: =>
      @uploadedProgress true
      setTimeout =>
        data = new FormData
        data.append('ajax', true)
        data.append('files[]', file.source) for file in @files()

        app('async').raw = true
        app('async').post '/upload', data, (d) =>
          app('filter') d

          @uploadedProgress false
          for file in @files()
            `delete file`
          @files([])
          return if d.status is 'error'

          for f in d.data.files
            UplFile.push f
      , 1


    createUploader: =>
      uploader = do @createUploaderInput
      uploader.addEventListener 'change', (e) =>
        app('NavController').uploaderWait true
        do (files = e.target.files) =>
          setTimeout =>
            for f in files
              @files.push new RuDev.File f
            app('NavController').uploaderWait false
          , 1
      do uploader.click


    createUploaderInput: ->
      uploader           = document.createElement 'input'
      uploader.type      = 'file'
      uploader.name      = 'images[]'
      uploader.multiple  = 'multiple'
      uploader.min       = 0
      return uploader

