{Nav} = App.Models

namespace App:Models:Nav:
  class Main
    constructor: ->
      nav = new Nav()
      nav.addButton(new Nav.Button('Документы',  'docs'))
      nav.addButton(new Nav.Button('История',    'history'))
      nav.addButton(new Nav.Button('Отмеченные', 'star'))
      nav.addButton(new Nav.Button('Группы',     'groups'))

      nav.click (target) =>
        for btn in nav.buttons()
          btn.active(btn.id is target.id)

      @buttons = nav.buttons

