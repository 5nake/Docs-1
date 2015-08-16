###
  namespace
###
unless window.namespace?
  class namespace
    constructor: (@name) ->
  window.namespace = ->
    args = arguments[0]
    target = window
    ns = []
    loop
      for subpackage, obj of args
        ns.push(subpackage)
        target = target[subpackage] or= new namespace(ns.join(':'))
        args = obj
      break unless typeof args is 'object'
    Class = args
    target = window if arguments[0].hasOwnProperty 'global'
    name = if !Class.name? # IE Fix
      args.toString().match(/^function\s(\w+)\(/)[1]
    else
      Class.name
    proto = target[name] or undefined
    target[name] = Class
    if proto?
      for i of proto
        target[name][i] = proto[i]


Object.defineProperty Object::, 'use', {
  enumerable: false,
  get: ->
    (cls) =>
      for i of cls
        @[i] = cls[i] unless @hasOwnProperty(i)
      for i of cls::
        @::[i] = cls::[i] unless @:: hasOwnProperty(i)
}


###
  define
###
unless window.define?
  unless Object.__defineGetter__?
    Object.__defineGetter__ = (val, cb) -> @[val] = cb()

  window.define = (args) ->
    for name, val of args
      continue if window[name]?
      ((name, val) ->
        window.__defineGetter__ name, -> val)(name, val)
    return window

###
  defined
###
unless window.defined?
  window.defined = (name) ->
    return window[name]?

###
  requestAnimationFrame
###
unless window.requestAnimationFrame?
  window.requestAnimationFrame = (->
    return window.webkitRequestAnimationFrame ||
        window.mozRequestAnimationFrame ||
        window.oRequestAnimationFrame ||
        window.msRequestAnimationFrame ||
        (callback, element) -> window.setTimeout callback, 1000 / 60)()

###
  equal
###
unless window.equal?
  window.equal = (op1, op2) ->
    return `op1 == op2`

###
  list
###
unless window.list?
  window.list = (object) ->
    return [key, val] for key, val of object

###
  echo & p
###
unless window.echo?
  window.p = window.puts = window.echo = (args...) -> console.log.apply console, args

###
  Exception
###
unless window.Exception
  window.Exception = window.Error

###
  ready
###
unless window.ready?
  class Status
    @readystate = false
    @callbacks = []
    document.onreadystatechange = =>
      if document.readyState is 'complete'
        Status.readystate = true
        do i for i in @callbacks
    @ready: (cb) ->
      return do cb if @readystate
      @callbacks.push cb
  window.ready = (cb = (->)) -> Status.ready(cb)
  window.start = (cls, alias) -> ready ->
    alias = cls.name.toLowerCase() unless alias?
    window[alias] = new cls


###
  classs alias
###
unless window.alias?
  window.alias = (data) ->
    [name, cls] = list data
    window[name] = cls


###
  private variables
###
window.$private = (name) ->
  unless defined 'ZERO_WIDTH_SPACE'
    define ZERO_WIDTH_SPACE: '​'
  return "#{ZERO_WIDTH_SPACE}#{name}#{ZERO_WIDTH_SPACE}"
