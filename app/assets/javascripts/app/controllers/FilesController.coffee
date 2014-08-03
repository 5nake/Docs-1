{Async} = Raid.Request

namespace global:
  class FilesController
    constructor: ->
      @preview  = ko.observable false

      @loaded   = ko.observable true
      UplFile.setup []

      @files = ko.observable []

      UplFile.onChange =>
        @files do UplFile.all

      setTimeout =>
        do @init
      , 10

    save: (file) ->
      file.save()

    remove: (file) ->
      do (file) ->
        do file.remove
      @preview false

    init: ->
      app('async').get '/upload/all', {ajax: true}, (d) =>
        for i in d.data.files
          UplFile.push i
        @files do UplFile.all
        @loaded false
