<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <title>RuDev Docs</title>
    <meta name="viewport" content="width=910, initial-scale=1.0" />
    {{app('asset')->make('assets/javascripts/manifest.js')->toLink(['async' => 'async'])}}
    {{app('asset')->make('assets/stylesheets/layout.scss')}}
    <meta name="csrf-param" content="authenticity_token" />
    <meta name="csrf-token" content="{{csrf_token()}}" />
    <link rel="shortcut icon" href="/img/favicon.png "/>
</head>
<body>
    <header>
        <section class="middle">
            <a href="{{URL::route('home')}}" class="logo">
                Docs
            </a>
            @if (!Auth::guest())
            <div class="user">
                <img src="{{Auth::user()->avatar}}" />
                <span class="user-login">
                    {{Auth::user()->login}}
                    <a href="{{URL::route('logout')}}">выйти</a>
                </span>
            </div>
            @endif
        </section>
    </header>
    @yield('content')
</body>
</html>