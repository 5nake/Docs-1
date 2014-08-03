namespace Raid:Debug:
  class Debug
    #
    trace: ->
      try
        getTrace = (t) ->
          result = []
          for i in t.split "\n"
            r   = i.match(/at(.*?)\((.*?)(?:\:([0-9:]+))?\)/)
            pos = if r?&&r[3]? then r[3].split ':' else [undefined, undefined]
            if r? && r.length
              result.push {
                func: r[1].trim()
                path: r[2]
                file: r[2].split('/')[r[2].split('/').length - 1]
                line: (pos[0] or= 0)|0
                char: (pos[1] or= 0)|0
              }
          return result
        t = getTrace((new Error).stack)
        return t.splice 1, t.length
      catch e
        return []
