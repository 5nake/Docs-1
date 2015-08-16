@extends('layout.master')

@section('content')
    <section nd-controller="AuthWindowController" class="page-auth-window">
        <script>
            var auth = {
                user: {!!$user->toJson()!!},
                errors: {!!json_encode($errors)!!}
            }
        </script>
        <!--ko foreach: errors-->
        <article class="label-error" nd-text="$data">&nbsp;</article>
        <!--/ko-->
        <!--ko ifnot: errors().length -->
        <article class="page-auth-profile">
            <img nd-attr="src: user.avatar, alt: user.login" />
            <h2 nd-text="user.login">&nbsp;</h2>
            <div class="page-auth-profile-bg">
                <div class="page-auth-profile-loader" nd-attr="
                    class: 'page-auth-profile-loader' + (ready()?' ready':'')
                "></div>
            </div>
        </article>
        <!--/ko-->
    </section>
@stop
