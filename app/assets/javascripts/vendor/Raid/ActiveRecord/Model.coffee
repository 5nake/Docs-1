{Finder} = Raid.ActiveRecord
{Object} = Raid.Converter
{Json}   = Raid.Converter

namespace Raid:ActiveRecord:
  class Model
    MODEL_DATA = 'data'

    collection = $private 'collection'
    events     = $private 'events'
    memory     = $private 'memory'

    @primaryKey: 'id'

    constructor: (data) ->
      @cache MODEL_DATA, -> Object::cloneData data
      obj = Object::cloneData data
      for key, val of obj
        @[key] = val

    @init: ->
      unless @[collection]?
        @[memory] = {}
        @[collection] = new Finder []
        @[events] = {
          load: []
        }

        for method of @[collection]
          unless @[method]?
            do (method) => @[method] = (args...) =>
              @[collection][method].apply(@[collection], args)

    @onChange: (cb = (->)) ->
      do @init
      @[collection].onChange cb

    @onAdd: (cb = (->)) ->
      do @init
      @[collection].onAdd cb

    @onRemove: (cb = (->)) ->
      do @init
      @[collection].onRemove cb

    @setup: (array) ->
      do @init
      for data in array
        @[collection].push new @(data)

    @push: (data) ->
      @[collection].push new @(data)

    @unshift: (data) ->
      @[collection].unshift new @(data)

    @merge: (arr) ->
      for item of arr
        @[collection].push new @(item)

    @find: (val) ->
      @findBy @primaryKey, val

    getCache: (key) ->
      if key?
        @[memory][$private(key)]
      else
        @[memory]

    @cache: (key, cb = (->)) ->
      key = $private key
      @[memory][key] = do cb unless @[memory][key]?
      return @[memory][key]

    cache: (key, cb = (->)) ->
      key = $private key
      @[memory] = {} unless @[memory]
      @[memory][key] = do cb unless @[memory][key]?
      return @[memory][key]

    toJson: -> Json::toString @cache MODEL_DATA

    toDataSource: -> @cache MODEL_DATA

    toString: -> do @toJson

