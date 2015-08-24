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
        <article class="item">
            <span class="item-title" nd-html="title"></span>
        </article>
    </section>


    <section class="footer">
        <a href="#" class="button selected-file-delete" title="Удалить">Удалить</a>
        <a href="#" class="button button-orange selected-file-checkout" title="Снять отметки"
           nd-click="clearSelected">Очистить</a>
    </section>
</section>
<!--/ko-->