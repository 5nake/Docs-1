namespace App:Support:Converter:
  class Object
    clone: (src) ->
      cleanData = @cloneData(src)
      for k, v of src
        if typeof src[k] is 'function'
          do (src, cleanData, k) -> cleanData[k] = (args...) ->
            src[k].apply(src[k], args)
      return cleanData

    cloneData: (src) ->
      return JSON.parse(JSON.stringify(src))
