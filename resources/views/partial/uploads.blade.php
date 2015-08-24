<a href="#" class="upload-files-button" nd-click="button.uploads.click"
    nd-attr="class: 'upload-files-button ' + (button.uploads.visible() ? 'enabled' : '')">

    <span class="nav-icon upload-files-icon"></span>
    Загрузки
    <!--ko if: uploader.files().length > 0-->
        <span class="nav-available" nd-text="uploader.files().length">0</span>
    <!--/ko-->
</a>