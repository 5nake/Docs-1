class Namespace
  constructor: ->
    @_classes         = {}
    window.namespace  = @setup

  setup: =>
    args   = arguments[0]
    target = window

    loop
      for subpackage, obj of args
        target = target[subpackage] or= {}
        args   = obj
      break unless typeof args is 'object'

    Class        = args
    target       = window if arguments[0].hasOwnProperty 'global'
    name = if !Class.name? # IE Fix
      args.toString().match(/^function\s(\w+)\(/)[1]
    else
      Class.name
    proto        = target[name] or undefined
    target[name] = Class

    if proto?
      target[name][i] = proto[i] for i of proto

    @_classes[name] = Class

window.namespace = (new Namespace).setup