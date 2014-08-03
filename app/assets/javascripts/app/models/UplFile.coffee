{Model}   = Raid.ActiveRecord
{Object}  = Raid.Converter

namespace global:
  class UplFile extends Model
    constructor: (data) ->
      @cache 'data', -> Object::cloneData data
      obj = ko.mapping.fromJS data
      @[key] = val for key, val of obj


      @updated = ko.observable false


      # Автоиспавление заголовка
      @title.subscribe (v) =>
        rmTimeout = =>
          clearTimeout @_timeout
          @_timeout = undefined
        rmTimeout() if @_timeout
        do (v) =>
          @_timeout = setTimeout =>
            rmTimeout() if @_timeout
            if v.trim() is ''
              @title('Безымянный #' + @id())
            else
              @title v.trim()
          , 1000

        @updated v.trim() isnt @getCache('data').title.trim()

    push: (data) ->
      obj = ko.mapping.fromJS data
      super obj

    getExtension: ->
      (parts = @path().split('.'))[parts.length - 1]

    changePermissions: =>
      if (@permissions()|0) is 1
        @permissions(2)
      else
        @permissions(1)
      @save()

    remove: ->
      app('async').post '/upload/delete/' + @id(), {_token: app('csrf'), ajax: true}, (response) =>
        if response.status is 'success'
          UplFile.remove (item) =>
            return item.id() is @id()

    save: ->
      data = {
        _token: app('csrf'),
        ajax: true
      }

      if @title() isnt @getCache('data').title
        data.title = @title()

      if @permissions() isnt @getCache('data').permissions
        data.permissions = @permissions()

      app('async').post '/upload/update/' + @id(), data, (response) =>
        if response.status is 'success'
          for key, d of response.data.file
            @[key] d
          @updated false

    getLink: ->
      '//' + document.location.host + '/d/' + @token()