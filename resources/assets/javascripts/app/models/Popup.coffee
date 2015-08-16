namespace App:Models:
  class Popup
    features:
      default: {
        toolbar: false
        scrollbars: false
        location: false
        statusbar: false
        menubar: false
        resizable: true
        width: 550
        height: 400
      }
      current: {}


    constructor: (url, features = {}) ->
      @features.current       = @merge(features, @features.default)
      @features.current.left  = @getMiddle().left
      @features.current.top   = @getMiddle().top

      popup = window.open url, 'auth', @makeFeatures(@features.current)
      popup.focus()

    getMiddle: =>
      {
      left: screen.width / 2 - @features.current.width / 2
      top: screen.height / 2 - @features.current.height / 2
      }

    makeFeatures: (obj = {}) =>
      output = []
      for i, j of obj
        output.push "#{i}=#{j}"
      return output.join(',')

    merge: (src, target) =>
      parseVal = (val) =>
        return 'no' if val is false
        return 'yes' if val is true
        return val

      for i, j of src
        target[i] = parseVal(j) unless target[i]?
      return target
