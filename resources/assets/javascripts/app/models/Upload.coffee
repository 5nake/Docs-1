{File} = App.Models.Upload

namespace App:Models:
  class Upload
    define FILE_SIZE_UPLOAD: config.upload.size
    define FILE_SIZE_FILES: config.upload.files

    constructor: ->
      @files = ko.observableArray []

    add: (file) =>
      return if @files().length >= FILE_SIZE_FILES

      instance = new File(file)
      if instance.isFile()
        @files.push instance

      onError = (instance) =>
        setTimeout =>
          @remove(instance)
        , 2000

      # If error remove file
      onError(instance) if instance.status.error()
      instance.status.error.subscribe => onError(instance)

      @

    upload: =>
      for file in @files()
        do (file) =>
          file.fileReader (event) =>
            file.status.success.subscribe =>
              setTimeout =>
                @remove file
              , 1000
            file.upload('docs.upload')


    reset: =>
      for i in @files()
        i.status.xhr().abort() if i.status.xhr()
      @files []
      @

    remove: (file) =>
      @files.remove (item) ->
        result = file.id is item.id
        if result && file.status.xhr()
          file.status.xhr().abort()
        return result
      @



