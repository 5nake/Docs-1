namespace App:Models:Upload:
  class Dropzone
    constructor: (@dom) ->
      @focused = ko.observable false
      @state = ko.observable ''

      if window.FileReader?
        do @make
      else
        throw new Error 'Can not create dropzone section. FileReader does not support'

    make:  =>
      @dom.ondragover   = (event) => @drag(event)
      @dom.ondragleave  = (event) => @leave(event)
      @dom.ondrop       = (event) => @drop(event)
      return @

    drag: (event) =>
      event.dataTransfer.dropEffect = 'copy'
      event.stopPropagation()
      event.preventDefault()
      @focused(true)
      false

    leave: (event) =>
      @focused(false)
      event.stopPropagation()
      event.preventDefault()
      false

    drop: (event) =>
      @focused(false)
      event.stopPropagation()
      event.preventDefault()

      for file in event.dataTransfer.files
        @upload(file)

      return false

    upload: (file) =>
      if file.size > FILE_SIZE_UPLOAD
        throw new Error "File to large (#{file.size}/#{FILE_SIZE_UPLOAD})"
      echo file