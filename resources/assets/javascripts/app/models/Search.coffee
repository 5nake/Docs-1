namespace App:Models:
  class Search
    constructor: ->
      @i18n     = new App.I18n.Converter

      @matchers = []

      @value    = ko.observable ''
      @items    = ko.observableArray []
      @found    = ko.observableArray []

      @applySearch()

      @translate = ko.observableArray []
      @applyI18n(@translate)

    applyI18n: (translate) =>
      @value.subscribe (value) =>
        if @found().length is 0
          @translate []
          for name, value of @i18n.detect(value).translate(value)
            @translate.push({
              name:   name
              value:  value
            })
      @


    applySearch: =>
      @value.subscribe (value) =>
        value = value.trim()
        if value.length > 0
          result = []
          for item in @items()
            item.reset()

            for matcher in @matchers
              result.push(item) if matcher(item, value)

          @found result

        else
          item.reset() for item in @items()
          @found @items()


    matchBy: (data, isObservable = true) =>
      do (data, isObservable) =>

        @match (doc, value) =>
          title  = doc[data]().toString().toLowerCase()
          value  = value.toString().toLowerCase()
          result = (title.indexOf(value) >= 0)

          # Highlight
          if result
            regexp = new RegExp(RegExp.escape(value), 'gi')
            highlighted = doc[data]().replace(regexp, "<span class=\"highlight\">#{value}</span>")
            if isObservable
              doc[data](highlighted)
            else
              doc[data] = highlighted

          return result

    match: (callback = (->)) =>
      @matchers.push callback
      @

    set: (items) =>
      @value ''
      @items items
      @found items
      @
