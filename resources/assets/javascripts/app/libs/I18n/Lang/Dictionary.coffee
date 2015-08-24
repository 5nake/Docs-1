namespace App:I18n:Lang:
  class Dictionary
    getTitle:         => @constructor.name
    getCharMap:       => ''
    getTranslations:  => []

    translate: (string) =>
      result = {}
      for translation in @getTranslations()
        result[translation.getTitle()] = translation.replace(@getCharMap(), string)
      return result

    replace: (charMap, string) =>
      map = @getCharMap().split('')
      for char, id in charMap
        string = string.replace(
          new RegExp(RegExp.escape(char), 'gi'),
          map[id]
        )
      return string


    detect: (string) =>
      count = 0
      for char in string
        count++ if @getCharMap().indexOf(char) >= 0
      return count / string.length * 100
