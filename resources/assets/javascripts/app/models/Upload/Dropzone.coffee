namespace App:Models:Upload:
  class Dropzone
    constructor: (@dom) ->
      @on = {
        drop:  ko.observableArray []
        enter: ko.observableArray []
        leave: ko.observableArray []
      }

      @focused = ko.observable false
      @state = ko.observable ''

      if window.FileReader?
        do @make
      else
        throw new Error 'Can not create dropzone section. FileReader does not support'

    make:  =>
      @dom.addEventListener 'click', =>
        uploader           = document.createElement 'input'
        uploader.type      = 'file'
        uploader.name      = 'images[]'
        uploader.multiple  = 'multiple'
        uploader.min       = 0
        uploader.addEventListener 'change', (event) =>
          @drop(event.target.files)
        uploader.click()


      @dom.ondragover   = (event) => @drag(event)
      @dom.ondragleave  = (event) => @leave(event)
      @dom.ondrop       = (event) =>
        event.stopPropagation()
        event.preventDefault()
        @drop(event.dataTransfer.files)
      return @

    drag: (event) =>
      @focused(true)
      event.dataTransfer.dropEffect = 'copy'
      event.stopPropagation()
      event.preventDefault()

      unless @focused()
        i(event) for i in @on.enter()

      false

    leave: (event) =>
      @focused(false)
      event.stopPropagation()
      event.preventDefault()
      i(event) for i in @on.leave()
      false

    drop: (files) =>
      @focused(false)
      for file in files
        @upload(file)

      return false

    onEnter: (callback) =>
      @on.enter.push callback
      @

    onLeave: (callback) =>
      @on.leave.push callback
      @

    onDrop: (callback) =>
      @on.drop.push callback
      @

    upload: (file) =>
      i(event, file) for i in @on.drop()
