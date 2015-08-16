{Model} = App.Model

namespace App:Models:
  class Document extends Model
    route:
      name: 'docs.all'
      method: METHOD_GET

    constructor: (args) ->
      super args

      @size((@size()/1024).toFixed(2) + ' kB')



      
