{File} = App.Models.Upload

namespace App:Models:
  class Upload
    define FILE_SIZE_UPLOAD: 1000000000
    define FILE_SIZE_FILES: 10

    constructor: ->
      @files = ko.observableArray []

    add: (file) =>
      @files.push new File(file)
      @

    remove: (file) =>
      @files.remove (item) -> file.id is item.id
      @



