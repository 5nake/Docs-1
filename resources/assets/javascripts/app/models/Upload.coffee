{File} = App.Models.Upload

namespace App:Models:
  class Upload
    define FILE_SIZE_UPLOAD: 1000000000
    define FILE_SIZE_FILES: 10

    constructor: ->
      @files = ko.observableArray []

    add: (file) =>
      instance = new File(file)
      if instance.isFile()
        @files.push instance
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



