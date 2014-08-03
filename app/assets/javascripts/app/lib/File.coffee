namespace RuDev:
  class File
    MAX_READER_SIZE = 100000000

    @id = 0

    constructor: (@source) ->
      @id   = File.id++
      @size = (@source.size/1024).toFixed(2) + 'kB'
      @name = @source.name
      @type = @source.type
      @ext  = (parts = @name.split('.'))[parts.length - 1]
      @preview = ko.observable ''

      if @source.size > MAX_READER_SIZE
        if console.warn?
          console.warn 'Can not read file. Filled with the maximum amount of avaliable file size'
        return

      if (
        @type is 'image/png' ||
        @type is 'image/jpg' ||
        @type is 'image/jpeg' ||
        @type is 'image/gif' ||
        @type is 'image/svg+xml'
      )
        @readImage (base64) =>
          @preview base64


    readImage: (cb = (->)) ->
      reader  = new FileReader
      reader.onload = (d) =>
        @parseImage(d.target.result, cb)
      reader.readAsDataURL @source


    #
    # Извращенская функция для сжатия base64 превьюшек
    #   и выдирания первого кадра из gif
    parseImage: (b64, cb) ->
      cnv         = document.createElement 'canvas'
      cnv.width   = 100
      cnv.height  = 64
      ctx         = cnv.getContext '2d'

      image = new Image
      image.src = b64
      image.onload = =>
        ctx.drawImage image, 0, 0, 100, image.height/(image.width/100)
        cb cnv.toDataURL()

    # @deprecated
    readFile: (cb = (->)) ->
      reader  = new FileReader
      reader.onload = (data) =>
      reader.readAsDataURL @source


