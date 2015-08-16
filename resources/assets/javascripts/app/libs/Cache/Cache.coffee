namespace App:Cache:
  class Cache
    prefix: 'cache.'
    cache:  60

    remember: (name, minutes, callback = (->)) =>
      return @read(name).value if @has name
      result = callback(
        (result) =>
          @write name, result, minutes if result?
      )
      @write name, result, minutes if result?
      return @

    put: (name, value, minutes = @cache) =>
      @write name, value, minutes
      return @

    set: (name, value) =>
      @put(name, value, 36000000)

    get: (key, defaultValue) =>
      data = @read(key)
      return data.value if data?
      return defaultValue

    has: (name) ->
      result = @read(name)
      return false if !result?
      return result.timestamp > time()

    read: (name) =>
      result = localStorage.getItem @prefix + name
      return if result? then JSON.parse(result) else undefined

    write: (name, val, minutes = @cache) =>
      localStorage.setItem(
        @prefix + name,
        JSON.stringify({
          value: val,
          timestamp: time() + minutes
        })
      )
      return @

    time = ->
      Math.ceil((new Date).getTime() / 1000 / 60)
