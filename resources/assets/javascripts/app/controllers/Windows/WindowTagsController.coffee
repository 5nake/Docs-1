{AbstractWindow} = App.Controllers.Windows

namespace App:Controllers:Windows:
  class WindowTagsController extends AbstractWindow
    @register 'tags'

    onShow: (files...) =>
      echo files
