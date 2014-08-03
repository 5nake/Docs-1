namespace Raid:Converter:
  class Xml
    toString: (node) ->
      if XMLSerializer?
        serializer = new XMLSerializer();
        return serializer.serializeToString(node);
      else if node.xml
        return node.xml
      return ''


    toData: (data) ->
      wrapper = document.createElement('div');
      wrapper.innerHTML = data;
      return wrapper.firstChild