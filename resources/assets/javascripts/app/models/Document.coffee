{Model} = App.Model
{Cache} = App.Cache

namespace App:Models:
  class Document extends Model
    @route:  'docs.all'
    @method: METHOD_GET

    preloader = 'data:image/gif;base64,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'
    error     = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAYCAMAAAClZq98AAAAaVBMVEUAAADnTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDxXURtjAAAAInRSTlMA+gXz6iHkvpH8xKZ/cVwSycC5UEs3LhsL2p2ZinhDQR8DV5YbawAAAKhJREFUKM+V09kWgjAMRdGkLciMAgLOev//I11gWcwEz/Nuk5eQxxBij1iRkGICiaFBzkGfHAkFAA4SYgD6759ebiTudGbgMUHTKgPALzaRCtBk3ksojqktwq+jmqMEiO1CtvsMORrgkqi+oMt/TlHWTvjQDX1uOkYJ2pICw8IRql371mBUPkQRljNpjyqNlcIeXbFa3qHSX0cmtSjDRqFFUth1CLtO6guopTAqF0yFmQAAAABJRU5ErkJggg=='

    constructor: (args) ->
      super args

      # Hash
      @hash         = (@id()).replace('/', ':')

      # Cache
      @cache        = new Cache
      @cache.driver = new Cache.SessionStorageDriver

      # Preview
      @previewUrl = @preview()
      @preview preloader
      @loadPreview(@previewUrl, @preview)

      # Title
      @defaultTitle = @title()

      # Size
      @bytes        = @size()
      @size((@size()/1024).toFixed(2) + ' kB')

      # Checked
      @checked      = ko.observable(@cache.get("[checked]#{@hash}", false))
      @checked.subscribe (value) => @cache.set("[checked]#{@hash}", value)

    loadPreview: (url, to) =>
      if @cache.has("[image]#{@hash}")
        return to(@cache.get("[image]#{@hash}", error))

      width  = 106
      height = 80

      canvas = document.createElement 'canvas'
      canvas.width = width
      canvas.height = height
      ctx    = canvas.getContext '2d'

      image = new Image
      image.onload = =>
        ctx.drawImage image, 0, 0, width, height
        data = canvas.toDataURL()
        @cache.set("[image]#{@hash}", data)
        to(data)
      image.onerror = =>
        to(error)
      image.src = url



    reset: =>
      @title @defaultTitle
      @

    check: =>
      @checked(!@checked())
      false



      
