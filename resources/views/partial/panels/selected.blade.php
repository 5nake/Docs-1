<section class="panel selected-files-list" nd-attr="class:
    'panel selected-files-list ' + (button.selected.visible()?'visible':'')
">

    <h2>
        <!--ko if: selected().length != 0-->
            Выделенные файлы
        <!--/ko-->
        <!--ko if: selected().length == 0-->
            Список пуст
        <!--/ko-->
    </h2>

    <section class="container" nd-foreach="selected">
        <article class="item" nd-click="function(){ checked(false); }">
            <input type="checkbox" checked readonly />
            <div class="item-icon" nd-attr="class: 'item-icon ' + (loaded()||error()?'':'loading')">
                <img src="/img/formats/default.png" alt="" nd-attr="src: preview, alt: title" />
            </div>
            <span class="item-title" nd-html="title"></span>
        </article>
    </section>

    <!--ko if: selected().length != 0-->
        <div class="footer-padding" style="height: 160px;"></div>
        <section class="footer">
            <a href="#" class="button selected-file-checkout" title="Снять отметки"
                nd-click="clearSelected">Снять выделения</a>
            <a href="#" class="button button-orange selected-file-delete" title="Удалить"
               nd-click="console.log"></a>
        </section>
    <!--/ko-->
</section>
