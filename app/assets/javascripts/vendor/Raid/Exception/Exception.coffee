{Debug} = Raid.Debug

namespace Raid:Exception:
  class Exception
    class Breakpoint extends Error
      constructor: (@message) ->
      toString: -> 'Breakpoint: ' + @message

    #
    constructor: (message) ->
      if navigator.userAgent.match(/Firefox/)
        console.error('Exception: ' + message)
        return new Breakpoint 'Остановка выполнения скрипта'

      try
        trace = Debug::trace()
        trace.shift()

        console.groupCollapsed(
            '%cException: ' + message ,
          'font-size: 13px; color: #fff; background: #900; border-radius: 2px; padding: 2px 8px 2px 20px; margin-left: -20px;'
        )

        writeMessage = (title, data) ->
          m = ''
          m += ' ' for i in [0..2]
          m += '%c' + title
          m += ' ' for i in [0..10 - title.length]
          m += '%c' + data
          return m

        for i in trace
          console.groupCollapsed(
            '%c' + i.func + ' %c(on line ' + i.line + ')',
            'font-weight: bold;',
            'color: #666; font-size: 11px;'
          )
          msg = ['']
          msg[0] += writeMessage('File:', i.file) + "\n"
          msg[0] += writeMessage('Function:', i.func) + "\n"
          msg[0] += writeMessage('Line:', i.line) + "\n"
          msg[0] += writeMessage('Character:', i.char) + "\n\n"
          msg[0] += '%c' + i.path + ':' + i.line
          msg.push 'font-weight: bold; color: #369;'
          msg.push 'font-weight: normal;'
          msg.push 'font-weight: bold; color: #369;'
          msg.push 'font-weight: normal;'
          msg.push 'font-weight: bold; color: #369;'
          msg.push 'font-weight: normal;'
          msg.push 'font-weight: bold; color: #369;'
          msg.push 'font-weight: normal;'
          msg.push 'color: #666; font-size: 11px;'
          console.log.apply(console, msg)
          console.groupEnd()

        console.groupEnd()
      catch e
        console.error message

      return new Breakpoint 'Остановка выполнения скрипта'
