<!--ko if: selected().length > 0-->
    <a href="#" class="selected-files-button" nd-click="button.selected.click"
        nd-attr="class: 'selected-files-button ' + (button.selected.visible() ? 'enabled' : '')">

        <span class="nav-icon selected-files-icon"></span>
        Выделенное
        <span class="nav-available" nd-text="selected().length">0</span>
    </a>
<!--/ko-->