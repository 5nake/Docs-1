namespace App:Models:Upload:
  class File
    id = 0
    define FILE_DEFAULT_IMAGE: '/img/formats/default.png'


    constructor: (file) ->
      @file  = file
      @id    = id++

      @status = {
        xhr:      ko.observable null
        uploaded: ko.observable 0
        readed:   ko.observable 0
        success:  ko.observable false
        error:    ko.observable false
      }
      @name  = ko.observable file.name
      @size  = ko.observable file.size
      @image = ko.observable FILE_DEFAULT_IMAGE
      @mime  = ko.observable file.type
      @ext   = ko.observable (parts = @name().split('.'))[parts.length - 1]

      if (
          @mime() is 'image/png' ||
          @mime() is 'image/jpg' ||
          @mime() is 'image/jpeg' ||
          @mime() is 'image/gif' ||
          @mime() is 'image/svg+xml' ||
          @mime() is 'image/x-icon'
      )
        @readImage file, (base64) => @image(base64)

      if file.size > FILE_SIZE_UPLOAD
        fileSize  = parseFloat(file.size / 1000).toFixed()
        available = parseFloat(FILE_SIZE_UPLOAD / 1000).toFixed()
        @status.error "File to large (#{fileSize}Kb/#{available}Kb)"



    isFile: () =>
      @size() > 0



    fileReader: (callback) =>
      return if @status.error()

      reader = new FileReader

      reader.onerror = (event) =>
        @status.error reader.error.message

      reader.onprogress = (event) =>
        @status.readed(@percentage(event.loaded || event.position, event.total))

      reader.onloadstart = (event) =>
        callback(@, event, reader)

      reader.readAsBinaryString @file



    upload: (action, options) =>
      return if @status.error()

      @status.xhr(xhr = new XMLHttpRequest())

      xhr.upload.addEventListener 'progress', (event) =>
        percentage = @percentage(event.loaded || event.position, event.total)
        @status.uploaded percentage

      xhr.addEventListener 'load', (event) =>
        @status.success true

      # not tested
      xhr.upload.addEventListener 'error', (event) => @state.error xhr.error.message
      # not tested
      xhr.addEventListener 'error', (event) => @state.error xhr.error.message

      xhr.open 'POST', route.route(action, {_token: config.csrf}), true
      xhr.overrideMimeType(@mime() || 'application/octet-stream')
      xhr.setRequestHeader 'X-File-Name', encodeURI(@name())
      xhr.setRequestHeader 'X-File-Type', encodeURI(@mime())

      data = new FormData
      data.append 'file', @file

      xhr.send data



    percentage: (current, total) =>
      return Math.ceil(current / total * 100)




    # Read image
    readImage: (file, cb = (->)) =>
      reader  = new FileReader
      reader.onload = (event) =>
        @parseImage(event.target.result, cb)
      reader.onerror = (event) =>
        @state.error reader.error.message
      reader.readAsDataURL file



    # Image scale
    parseImage: (base64, callback) =>
      cnv         = document.createElement 'canvas'
      cnv.width   = 160
      cnv.height  = 120
      ctx         = cnv.getContext '2d'

      image = new Image
      image.src = base64
      width  = 160
      height = image.height/(image.width/160)
      left   = (160 - width) / 2
      top    = (120 - height) / 2

      image.onload = =>
        ctx.drawImage image, left, top, width, height
        callback cnv.toDataURL()
