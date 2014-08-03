{Json}   = Raid.Converter
{Object} = Raid.Converter

namespace Raid:Support:
  class Collection
    array   = $private 'array'
    events  = $private 'events'

    constructor: (arr = []) ->
      @[array]  = arr
      @[events] = {
        add:    []
        remove: []
        change: []
      }

      @__defineGetter__ 'length', => @[array].length

    @make: (arr = []) ->
      return new @ arr

    all: -> @[array]

    each: (cb = (->)) ->
      cb i for i in @[array]

    onChange: (cb = (->)) ->
      @[events].change.push cb

    onAdd: (cb = (->)) ->
      @[events].add.push cb

    onRemove: (cb = (->)) ->
      @[events].remove.push cb

    push: (item) ->
      @[array].push item
      do i for i in @[events].add
      do i for i in @[events].change
      @

    pop: ->
      do @[array].pop
      do i for i in @[events].remove
      do i for i in @[events].change
      @

    unshift: (item) ->
      @[array].unshift item
      do i for i in @[events].add
      do i for i in @[events].change
      @

    shift: ->
      do @[array].shift
      do i for i in @[events].remove
      do i for i in @[events].change
      @

    remove: (cb) ->
      newArray = []
      removed    = false
      for i, j in @[array]
        if cb(i)
          removed = true
        else
          newArray.push i

      @[array] = newArray

      if removed
        do i for i in @[events].remove
        do i for i in @[events].change
      @

    removeAll: ->
      @[array] = []
      do i for i in @[events].remove
      do i for i in @[events].change
      @


    forget: (id) ->
      @pull id
      do i for i in @[events].remove
      do i for i in @[events].change
      @

    get: (id) -> @[array][id]

    has: (id) -> @[array][id]?

    isEmpty: -> @length is 0

    first: (filter) ->
      if filter
        for i in @[array]
          return i if filter(i)
      else
        return @[array][0]

    last: (filter) ->
      do @reverse
      result = @first(filter)
      do @reverse
      return result

    merge: (items) ->
      do i for i in @[events].add
      do i for i in @[events].change
      @[array] = @[array].concat(items)
      @

    pull: (id) ->
      do i for i in @[events].remove
      do i for i in @[events].change
      @[array].splice id, 1

    random: ->
      rnd = Math.round(Math.random() * @[array].length)
      @[array][rnd]

    reverse: ->
      @[array].reverse()
      @

    splice: (offset, length) ->
      do i for i in @[events].remove
      do i for i in @[events].change
      @[array].splice offset, length

    sort: (cb = (->)) ->
      @[array] = @[array].sort cb

    sum: (cb = (->)) ->
      result = undefined
      for i in @[array]
        val = cb(i)
        unless result?
          result = val
        else
          result += val
      return result

    clone: ->
      return new @constructor @[array]

    toArray: -> return @[array]

    toJson: -> Json::toString @[array]

    toString: -> do @toJson

