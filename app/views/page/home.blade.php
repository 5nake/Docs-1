@section('content')
    @include('partial.uploads')
    <section class="container files">
        <aside class="targets" data-controller="NavController">
            <a href="javascript:void(0);" class="upload"
                data-bind="click: uploadFiles, attr: {
                    class: 'upload ' + (uploaderWait()?' upload-wait':'')
                }">
                <span class="upload-shadow"></span>
            </a>
            <nav>
                <span class="title">Фильтр</span>
                <a href="#">Фото</a>
                <a href="#">Видео</a>
                <a href="#">Аудио</a>
                <a href="#">Документы</a>
            </nav>
        </aside>
        <section class="file-list" data-controller="FilesController">
            <section class="file-preview" data-bind="attr: {
                class: 'file-preview' + (preview()?' file-preview-shown':'')
            }">
                <!--ko if: preview()-->
                    @include('partial.preview')
                <!--/ko-->
            </section>
            <!--ko if: loaded-->
                <div class="file-preload"></div>
            <!--/ko-->
            <!--ko ifnot: loaded-->
                <!--ko if: files().length == 0-->
                <h2 class="no-files">Файлов нет</h2>
                <!--/ko-->
                <!--ko if: files().length != 0-->
                    <!--ko foreach: files-->
                        <article class="file-item" data-bind="click: function(){
                            $root.preview($data)
                        }, attr: {
                            title: title() + ' (' + ((size()/1024).toFixed(2)) + 'Kb)'
                        }">
                            <div class="file-item-preview">
                                <!--ko if: updated-->
                                <span class="file-item-updated">*</span>
                                <!--/ko-->
                                <!--ko if: (preview() != '/img/icons/undefined.png') -->
                                <img src="/img/icons/undefined.png" alt="Undfined preview"
                                     data-bind="attr: {src: preview}" />
                                <!--/ko-->
                                <!--ko if: (preview() == '/img/icons/undefined.png') -->
                                <img src="/img/icons/undefined.png" class="no-preview" alt="Undfined preview" />
                                <span class="preview-extension" data-bind="text: getExtension()">&nbsp;</span>
                                <!--/ko-->
                            </div>
                            <div class="file-item-title" data-bind="text: title()">&nbsp;</div>
                        </article>
                    <!--/ko-->
                <!--/ko-->
            <!--/ko-->
        </section>
    </section>
@stop
