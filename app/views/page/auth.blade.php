@section('content')
    @include('partial.header')
    <section class="auth container">
        <h2>Авторизация</h2>
        <a href="{{$authLink}}" class="button">Вход</a>
    </section>
@stop
