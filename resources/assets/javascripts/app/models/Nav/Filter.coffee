{Nav} = App.Models

namespace App:Models:Nav:
  class Filter
    constructor: ->
      filter = new Nav()
      filter.addButton(new Nav.Button('Изображения', 'images'))
      filter.addButton(new Nav.Button('Аудио',       'audio'))
      filter.addButton(new Nav.Button('Видео',       'video'))
      filter.addButton(new Nav.Button('Текст',       'text'))
      filter.addButton(new Nav.Button('Ссылки',      'links'))
      filter.addButton(new Nav.Button('Другое',      'another'))

      filter.click (target) =>
        target.active(!target.active())

      @buttons = filter.buttons