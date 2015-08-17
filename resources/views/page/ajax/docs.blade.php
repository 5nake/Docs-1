<section nd-controller="DocsController" class="animated fadeIn page-docs container-12">
    <header class="grid-12">
        <div class="header-push grid-2"></div>
        <nav class="main-nav">
            @include('header.uploads')
        </nav>
    </header>

    <main>
        <aside class="grid-2 docs-nav">
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
            <section class="footer grid-2">
                <span class="disc-quote">469.42Mb / 1024.00Mb</span>
                <div class="disc-quote-container">
                    <div class="disc-quote-line" style="width: 5%"></div>
                </div>
            </section>
        </aside>


        <table class="content">
            <tr>
                <td class="content-push">
                    &nbsp;
                </td>
                <td class="docs-container">
                    <section class="" nd-foreach="documents">
                        <article class="document">
                            <figure class="document-preview" nd-attr="style: 'background-image:url(' + preview() + ');'"></figure>

                            <span class="document-title" nd-text="title"></span>
                            <time class="document-time" nd-text="created_at"></time>

                            <span class="tooltip">
                                <span nd-text="title">&nbsp;</span>
                                <br />
                                <span class="tooltip-small" nd-text="size">&nbsp;</span>
                            </span>
                        </article>
                    </section>
                </td>
            </tr>
        </table>
    </main>
</section>
