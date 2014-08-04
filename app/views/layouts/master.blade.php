<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <title>{{$title}}</title>
    <meta name="viewport" content="width=910, initial-scale=1.0" />
    {{app('asset')->make('assets/javascripts/manifest.js')->toLink(['async' => 'async'])}}
    {{app('asset')->make('assets/stylesheets/layout.scss')}}
    <meta name="csrf-param" content="authenticity_token" />
    <meta name="csrf-token" content="{{csrf_token()}}" />
    <link rel="shortcut icon" href="/img/favicon.png "/>
</head>
<body>
    @yield('content')
</body>
</html>
