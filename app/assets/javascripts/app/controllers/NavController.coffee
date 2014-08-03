namespace global:
  class NavController
    constructor: ->
      @uploaderWait = ko.observable false

    uploadFiles: =>
      if @uploaderWait() is false
        do app('UploaderController').createUploader