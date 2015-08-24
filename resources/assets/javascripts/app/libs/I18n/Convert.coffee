namespace App:I18n:
  class Converter
    dictionaries = [
      #new App.I18n.Lang.TransRu,
      new App.I18n.Lang.Ru,
      #new App.I18n.Lang.TransEn,
      new App.I18n.Lang.En,
    ]

    detect: (string) =>
      max = null
      for dictionary in dictionaries
        max = dictionary unless max?
        if dictionary.detect(string) > max.detect(string)
          max = dictionary
      return max
      #



