<section nd-controller="DocsController" class="animated fadeIn page-docs container-12">
    <header class="grid-12">
        <div class="header-push"></div>
        <nav class="main-nav">
            @include('partial.uploads')
            @include('partial.selected')
        </nav>
    </header>

    <main>
        <aside class="docs-nav">
            <article class="docs-header">
                <a href="#" class="logo"></a>
            </article>

            <article class="upload-section" nd-attr="class: 'upload-section ' + dropzoneState()"
                     data-id="uploadSection">
                <div class="upload-section-borders"></div>
            </article>

            <nav>
                <span class="title">Навигация</span>
                <span nd-foreach="nav">
                    <a href="#" nd-click="focus" nd-attr="class: ('icon-' + icon()) + (active()?' active':'')"
                       nd-text="title">&nbsp;</a>
                </span>
            </nav>

            <nav>
                <span class="title">Фильтр</span>
                <span nd-foreach="filter">
                    <a href="#" nd-click="focus" nd-attr="class: ('icon-' + icon()) + (active()?' active':'')"
                       nd-text="title">&nbsp;</a>
                </span>
            </nav>


            <div class="footer-padding"></div>
            <section class="footer">
                <span class="disc-quote">469.42Mb / 1024.00Mb</span>

                <div class="disc-quote-container">
                    <div class="disc-quote-line" style="width: 5%"></div>
                </div>
            </section>
        </aside>

        <table class="content">
            <tr>
                <td class="content-push" nd-attr="class: 'content-push ' + (
                    (button.uploads.visible() || button.selected.visible())?'content-push-show':''
                )">
                    &nbsp;
                    @include('partial.panels.uploads')
                    @include('partial.panels.selected')
                </td>
                <td class="docs-container">

                    <section class="docs-search">
                        <input type="text" data-bind="value: search.value, valueUpdate: 'input'" placeholder="Поиск" />

                        <!--ko if: (search.found().length == 0) && (search.items().length > 0)-->
                        <article class="docs-search-translation">
                            <!--ko foreach: search.translate-->
                                <span class="docs-i18n" nd-click="$parent.dict">
                                    <span class="docs-i18n-title" nd-text="name"></span>
                                    <span class="docs-i18n-content" nd-text="value"></span>
                                </span>
                            <!--/ko-->
                        </article>
                        <!--/ko-->
                    </section>

                    <section class="" nd-foreach="documents">
                        @include('partial.document')
                    </section>

                    <!--ko if: documents().length == 0-->
                    <h2>Файлов не найдено</h2>
                    <!--/ko-->
                </td>
            </tr>
        </table>
    </main>
</section>
