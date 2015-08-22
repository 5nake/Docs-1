<a href="#" nd-click="buttonUploads.click" nd-attr="class: (buttonUploads.visible() ? 'enabled' : '')">
    Загрузки
    <!--ko if: uploader.files().length > 0-->
    <span class="nav-available" nd-text="uploader.files().length">0</span>
    <!--/ko-->
</a>


<section class="nav-dropdown upload-file-list" nd-attr="class: 'nav-dropdown upload-file-list ' +
    (buttonUploads.visible() ? 'visible' : '')">

    <section class="upload-file-list-container">
        <!--ko foreach: uploader.files-->
        <article class="upload-file-item" nd-click="$parent.uploader.remove">
            <!--ko if: status.error-->
                <div class="upload-file-error">
                    <span nd-text="status.error"></span>
                </div>
            <!--/ko-->

            <!--ko if: status.success-->
                <div class="upload-file-success">
                </div>
            <!--/ko-->

            <div class="upload-file-preview">
                <img src="/img/formats/default.png" alt="" nd-attr="src: image, alt: name" />
            </div>

            <div class="upload-file-title" nd-text="name">
                undefined
            </div>

            <div class="upload-file-preloader">
                <span class="upload-file-state">
                    Ожидание&hellip;
                </span>

                <div class="upload-file-progress">
                    <div class="upload-file-upload-progress" nd-attr="
                        style: 'width: ' + status.uploaded() + '%'
                    "></div>
                    <div class="upload-file-read-progress" nd-attr="
                        style: 'width: ' + status.readed() + '%'
                    "></div>
                </div>
            </div>
        </article>
        <!--/ko-->

        <!--ko if: uploader.files().length == 0-->
        <h3>Список загрузок пуст</h3>
        <!--/ko-->
    </section>


    <section class="footer">
        <!--ko if: uploader.files().length > 0-->
            <a href="#" nd-click="uploader.upload" class="button">Загрузить</a>
            <a href="#" nd-click="uploader.reset" class="button reset">Очистить</a>
        <!--/ko-->
        <!--ko if: uploader.files().length == 0-->
            <a href="#" class="button disabled">Загрузить</a>
            <a href="#" class="button disabled reset">Очистить</a>
        <!--/ko-->
    </section>
</section>
