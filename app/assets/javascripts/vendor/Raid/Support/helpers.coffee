unless window.app?
  window.app = (name) -> App[name]

unless window.list?
  window.list = (object) ->
    return [key, val] for key, val of object

unless window.echo?
  window.echo = (args...) ->
    console.log.apply console, args

unless window.ready?
  class Status
    @readystate = false
    @callbacks  = []

    document.onreadystatechange = =>
      if document.readyState is 'complete'
        Status.readystate = true
        do i for i in @callbacks

    @ready: (cb) ->
      return do cb if @readystate
      @callbacks.push cb

  window.ready = (cb = (->)) ->
    Status.ready(cb)
