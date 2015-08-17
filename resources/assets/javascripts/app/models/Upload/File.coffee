namespace App:Models:Upload:
  class File
    id = 0
    define FILE_DEFAULT_IMAGE: '/img/formats/default.png'


    constructor: (file) ->
      @id    = id++
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

    # Read image
    readImage: (file, cb = (->)) =>
      reader  = new FileReader
      reader.onload = (d) =>
        @parseImage(d.target.result, cb)
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