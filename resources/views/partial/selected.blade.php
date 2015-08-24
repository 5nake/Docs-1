<!--ko if: selected().length > 0-->
    <a href="#" class="selected-files-button" nd-click="button.selected.click"
        nd-attr="class: 'selected-files-button ' + (button.selected.visible() ? 'enabled' : '')">

        <span class="nav-icon selected-files-icon"></span>
        Выделенное
        <span class="nav-available" nd-text="selected().length">0</span>
    </a>
<!--/ko-->


<section class="nav-dropdown selected-files-list"
         nd-attr="class: 'nav-dropdown selected-files-list ' + (button.selected.visible() ? 'visible' : '')">

    <section nd-foreach="selected">
        <span nd-text="title"></span>
    </section>

    <section class="footer">
        <a href="#" title="Удалить">D</a>
        <a href="#" title="Снять отметки">D</a>
    </section>
</section>
