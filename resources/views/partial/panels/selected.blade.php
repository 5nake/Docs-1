<!--ko if: button.selected.visible()-->
<section class="panel selected-files-list">

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
            <!--ko if: selected().length == 1-->
                <a href="#" class="button button-green selected-file-open" title="Открыть"
                    nd-click="console.log">Открыть</a>
            <!--/ko-->
            <!--ko if: selected().length != 1-->
                <a href="#" class="button button-disabled selected-file-open" title="Открыть"
                   nd-click="console.log">Открыть</a>
            <!--/ko-->

            <a href="#" class="button selected-file-tags" title="Добавить теги"
                nd-click="tagsSelected">Добавить теги</a>

            <a href="#" class="button button-orange selected-file-delete" title="Удалить"
                nd-click="console.log">Удалить выделенное</a>

            <a href="#" class="button selected-file-checkout" title="Снять отметки"
                nd-click="clearSelected">Снять выделения</a>
        </section>
    <!--/ko-->
</section>
<!--/ko-->
