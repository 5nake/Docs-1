namespace App:Support:Converter:
  class Json
    toData: (data) ->
      return JSON.parse(data)

    toString: (data) ->
      return JSON.stringify(data)
