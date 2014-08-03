<section data-controller="UploaderController">
    <!--ko if: files().length != 0-->
    <article class="container ready-files">
        <!--ko if: uploadedProgress-->
            <div class="uploaded-progress">
                <div class="uploaded-progress-line">
                    <div data-bind="attr: {style: 'width:' + (loaded()/total()*100) + '%'}" class="uploaded-progress-line-in"></div>
                </div>
                <div class="uploaded-text">
                    <span data-bind="text: (loaded()/1024).toFixed(2) + 'Kb'"></span>/<span data-bind="text: (total()/1024).toFixed(2) + 'Kb'"></span>
                </div>
            </div>
            <div class="clear"></div>
        <!--/ko-->
        <!--ko ifnot: uploadedProgress-->
            <!--ko foreach: files-->
            <div class="uploaded-file-item"
                data-bind="attr: {title: name}">
                <a href="#" data-bind="click: function(){
                    $root.remove(id)
                }" class="upload-file-remove"></a>
                <div class="uploaded-file-icon">
                    <!--ko if: preview-->
                    <img src="/img/icons/undefined.png"
                         data-bind="attr: {src: preview, alt: name}"
                         alt="no preview" />
                    <!--/ko-->
                    <!--ko ifnot: preview-->
                    <img src="/img/icons/undefined.png" alt="no preview" />
                    <span class="uploaded-file-ext" data-bind="text: ext"></span>
                    <!--/ko-->
                </div>
                <span class="uploaded-file-name"
                    data-bind="text: name">&nbsp;</span>
                <span class="uploaded-file-size">
                    <!--ko text: size--><!--/ko-->
                </span>
            </div>
            <!--/ko-->
            <div class="clear uploaded-line"></div>
            <a href="javascript:void(0)" class="button"
               data-bind="click: uploadFiles">Загрузить</a>
        <!--/ko-->
    </article>
    <!--/ko-->
</section>