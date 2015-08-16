{Cache} = App.Cache
{Model} = App.Model
{User}  = App.Models
{Ajax}  = App.Request

namespace App:Models:
  class Auth
    define ACTION_LOGOUT: 'logout'

    user  = null
    guest = ko.observable true

    guest: =>
      guest()

    check: =>
      !guest()

    login: (cb = (->)) =>
      return cb() unless guest()?
      do (cb) =>
        subscriber = guest.subscribe (status) =>
          unless status
            cb()
            subscriber.dispose()


    subscribe: (cb) =>
      guest.subscribe (status) => cb(status)
      @

    loginByData: (args) =>
      Cache::set('user', args)

    user: =>
      restore()

    logout: (cb) =>
      @loginByData({})
      @guest(true)
      restore(true)

      unless cb?
        cb = ->
          (new Ajax).with({ method: METHOD_POST }).request(route.route('auth.logout', ->))
          App.Controllers.PreloaderController::load()
      cb()
      @

    restore = (permanent = false) ->
      user = null if permanent

      unless user?
        data = Cache::get('user', {})
        if Object.keys(data).length
          user = new App.Models.User(data)
      guest(user is null)
      return user


    # Sync
    do restore
    setInterval((=> restore()), 1000)

    # Subscribes
    Ajax.subscribe (response, status) =>
      if response.actions? && response.actions.indexOf(ACTION_LOGOUT) >= 0
        Auth::logout()




