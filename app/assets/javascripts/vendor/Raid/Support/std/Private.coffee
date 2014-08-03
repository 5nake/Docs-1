window.$private = (ch) ->
  name = ch
  charset = [
    'a', 'b', 'c', 'd', 'e',
    'f', 'g', 'h', 'i', 'j',
    'k', 'l', 'm', 'n', 'o',
    'p', 'q', 'r', 's', 't',
    'u', 'v', 'w', 'x', 'y',
    'z', '_', '$'
  ]
  for i, j in charset
    ch = ch.replace(new RegExp(i, 'ig'), pack('S', '\\x0' + j))
  return "[private #{name}]" + ch
