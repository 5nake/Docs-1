<!--ko if: button.uploads.visible()-->
<section class="panel upload-file-list">

    <h2>
        <!--ko if: uploader.files().length != 0-->
            Список загрузок
        <!--/ko-->
        <!--ko if: uploader.files().length == 0-->
            Список загрузок пуст
        <!--/ko-->
    </h2>

    <section class="container">
        <!--ko foreach: uploader.files-->
        <article class="item" nd-click="$parent.uploader.remove">
            <!--ko if: status.error-->
                <div class="item-error" nd-text="status.error"></div>
            <!--/ko-->
            <!--ko if: status.success-->
                <div class="item-success"></div>
            <!--/ko-->

            <div class="item-icon">
                <img src="/img/formats/default.png" alt="" nd-attr="src: image, alt: name" />
            </div>
            <div class="item-title" nd-html="name"></div>

            <!--ko if: !status.error() && !status.success()-->
                <div class="progress">
                    <div class="progress-upload" nd-attr="
                        style: 'width: ' + status.uploaded() + '%'
                    "></div>
                    <div class="progress-read" nd-attr="
                        style: 'width: ' + status.readed() + '%'
                    "></div>
                </div>
            <!--/ko-->
        </article>
        <!--/ko-->
    </section>


    <section class="footer">
        <!--ko if: uploader.files().length > 0-->
        <a href="#" class="button button-green upload-file-action" nd-click="uploader.upload">Загрузить</a>
        <a href="#" class="button button-orange upload-file-clear" nd-click="uploader.reset">Очистить</a>
        <!--/ko-->
    </section>
</section>
<!--/ko-->
