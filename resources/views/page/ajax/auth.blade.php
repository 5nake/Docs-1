<section nd-controller="AuthController" class="animated fadeInDown page-auth container-12">

    <article class="grid-6">
        <h2>Добро пожаловать в Docs</h2>

        <p>
            RuDev Docs &mdash; <a href="https://github.com/Developers-RuDev/Docs">Open Source проект</a>,
            предоставляющий высокую скорость доступа к файлам в любой момент времени.
        </p>

        <p>
            Администрация ресурса гарантирует, что никакая личная информация,
            размещённая на серверах не будет просматриваться, удаляться или редактироваться
            третьими лицами, за исключением случаев, предусмотренных в законодательстве РФ.
        </p>
    </article>


    <article class="grid-6">
        <div class="box-content">
            <section class="box-group text-center">
                <small>Авторизация</small>
            </section>

            <section class="box-group auth-social">

                <a href="#" nd-click="auth" data-url="{{App\Api\RuDev::get()->getAuthLink()}}"
                        class="button button-orange button-rudev">
                    <span></span>
                    Вход
                </a>
            </section>
        </div>
    </article>

</section>

