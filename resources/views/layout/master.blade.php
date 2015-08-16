<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@section('page.title') RuDev: Docs @show</title>
    <script>window.config = {!!json_encode([
        'csrf' => csrf_token(),
        'env' => App::environment()
    ])!!}</script>
    {!!asset_link('manifest.js')!!}
    {!!asset_link('layout.scss')!!}
</head>
<body>
    <main id="master">
        @yield('content')
    </main>
</body>
</html>
