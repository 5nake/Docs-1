{Exception} = Raid.Exception
{Async}     = Raid.Request

class Application
  CONTROLLER_NS = window

  constructor: ->
    @async = new Async
    @__defineGetter__ 'csrf', ->
      document.querySelectorAll('[name=csrf-token]')[0].getAttribute('content')

  run: ->
    doms = document.querySelectorAll('[data-controller]')
    for dom in doms
      name        = dom.getAttribute 'data-controller'
      controller  = CONTROLLER_NS[name]
      unless controller?
        throw new Exception "Undefined controller `#{name}`"
      ko.applyBindings(@[name] = new controller(dom), dom)





(window.App = new Application)
document.addEventListener 'readystatechange', ->
   if document.readyState is 'complete'
     do App.run
, false
