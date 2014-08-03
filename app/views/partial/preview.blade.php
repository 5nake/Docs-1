<table>
    <tr>
        <td>
            <div class="file-preview-icon">
                <img src="/img/icons/undefined.png"
                     data-bind="attr: {src: preview().preview}" />
            </div>
        </td>
        <td class="file-preview-text">
            <input type="text" class="file-preview-title"
                   data-bind="value: preview().title, valueUpdate: 'input'" />
            <div class="clear"></div>

            <a href="#" class="button" data-bind="attr: {
                class: 'button' + (preview().updated()?'':' disabled')
            }, click: function(){
                $root.save(preview())
            }">Сохранить</a>

            <a href="#" target="_blank" data-bind="attr: {
                href: preview().getLink()
            }" class="button">Открыть</a>

            <a href="#" data-bind="click: function(){
                $root.remove(preview())
            }" class="button delete">Удалить</a>
        </td>
        <td>
            <div class="file-preview-info">
                Размер: <span data-bind="text: (preview().size()/1024).toFixed(2) + 'Kb'"></span>
            </div>
            <div class="file-preview-info">
                Права:
                <a href="#" data-bind="click: function(){ preview().changePermissions(); }">
                <!--ko if: (preview().permissions()|0) == {{UplFile::PERM_PRIVATE}}--><span class="file-preview-private">Личный</span><!--/ko-->
                <!--ko if: (preview().permissions()|0) == {{UplFile::PERM_PUBLIC}}--><span class="file-preview-public">Публичный</span><!--/ko-->
                </a>
            </div>
            <div class="file-preview-info">
                Тип: <span data-bind="text: preview().mime"></span>
            </div>
            <div class="file-preview-info">
                Загружено: <span data-bind="text: preview().created_at"></span>
            </div>
            <div class="file-preview-info">
                Изменено: <span data-bind="text: preview().updated_at"></span>
            </div>
        </td>
    </tr>
</table>