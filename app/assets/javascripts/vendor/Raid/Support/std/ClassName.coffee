fn = (cls) ->
  if typeof cls is 'object'
    cls = cls.constructor
  else if typeof cls isnt 'function'
    return typeof cls

  name = unless cls.name? # IE Fix
    cls.toString().match(/function\s(\w+)\(/)[1]
  else
    cls.name
  return name
window.nameof = fn