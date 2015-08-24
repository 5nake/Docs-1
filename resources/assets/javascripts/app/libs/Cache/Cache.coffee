###
  Examples:

  As new object
  ```js
    var cart = new Cache('cart.')
    cart.set('item', {number: '+79039009090', cost: 9000})
    console.log(cart.get('item', {number: '', cost: 0}))
  ```

  As prototype
  ```coffee
  Cache::remember 'item', -> {number: +79039009090', cost: 9000}
  ```
###
namespace App:Cache:
  class Cache
    class ICacheDriver
      get: (value) ->       throw new Error('Can not call abstract method get')
      set: (key, value) ->  throw new Error('Can not call abstract method set')
      remove: (key) ->      throw new Error('Can not call abstract method remove')
      all: ->               throw new Error('Can not call abstract method all')

    class @LocalStorageDriver extends ICacheDriver
      get: (value) ->       localStorage.getItem(value)
      set: (key, value) ->  localStorage.setItem(key, value)
      remove: (key) ->      localStorage.removeItem(key)
      all: ->               Object.keys(localStorage)

    class @SessionStorageDriver extends ICacheDriver
      get: (value) ->       sessionStorage.getItem(value)
      set: (key, value) ->  sessionStorage.setItem(key, value)
      remove: (key) ->      sessionStorage.removeItem(key)
      all: ->               Object.keys(sessionStorage)


    driver: new @LocalStorageDriver
    prefix: 'cache.'
    cache:  60

    timestamp = -> Math.ceil((new Date).getTime() / 1000 / 60)

    ###
      Create a new Cache object with target prefix (can be nullable)
    ###
    constructor: (namespace) ->
      @prefix = "#{namespace}." if namespace?

    ###
      Remember value of callback
      Usage:
        .remember('key', function(){ return 'value'; })
        .remember('key', 100500, function(){ return 'value'; })
    ###
    remember: (name, minutes, callback = (->)) =>
      if minutes instanceof Function
        [callback, minutes] = [minutes, @cache]

      return @get(name) if @has name
      result = callback(
        (result) => (@put(name, minutes, result) if result?)
      )
      @put name, minutes, result if result?
      return @

    ###
      Remember variant value
      Usage:
        .put('key', 'value')
        .put('key', 100500, 'value')
        .put('key', function(){ return 'value'; })
        .put('key', 100500, function(){ return 'value'; })
    ###
    set: (args...) => @put(args...)
    put: (name, minutes, value) =>
      unless value?
        [value, minutes] = [minutes, @cache]

      if value instanceof Function
        return @remember(name, minutes, value)

      @driver.set(
        @prefix + name,
        JSON.stringify({
          value:      value
          timestamp:  timestamp() + minutes
        })
      )
      return @

    ###
      Check value in storage
    ###
    has: (name) =>
      result = @get(name, undefined, true)
      return false unless result?
      return result.timestamp > timestamp()

    ###
      Get value of storage
    ###
    get: (name, defaultValue = {}, asRawData = false) =>
      result = @driver.get(@prefix + name)
      if result?
        data = JSON.parse(result)
        return if asRawData then data else data.value
      defaultValue

    ###
      Return all values
    ###
    all: =>
      prefix = @prefix.replace /[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, '\\$&' # escape
      result = {}
      for key in @driver.all()
        if matches = (new RegExp("^#{prefix}(.*?)$", 'g')).exec(key)
          result[key] = @get(matches[1])
      result

    ###
      Remove by key
    ###
    remove: (key) =>
      @driver.remove(@prefix + key)

    ###
      Remove values of storage (with prefix)
    ###
    clear: =>
      result = []
      for key of @all()
        result.push(key)
        @driver.remove(key)
      result



