{Collection} = Raid.Support

namespace Raid:ActiveRecord:
  class Finder extends Collection
    array   = $private 'array'

    where: (key, as, target) ->
      result = []
      for i in @[array]
        switch as
          when '='
            if `i[key] == target`
              result.push i
          when '>='
            if i[key] >= target
              result.push i
          when '<='
            if i[key] <= target
              result.push i
          when '<'
            if i[key] < target
              result.push i
          when '>'
            if i[key] > target
              result.push i
          when '<>'
            if i[key] isnt target
              result.push i
          when '!='
            if i[key] isnt target
              result.push i

      return new Finder result

    findBy: (key, val) ->
      result = @where key, '=', val
      return if result.length > 0
        result.first()
      else
        undefined