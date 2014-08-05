@section('content')
    @include('partial.header')
    <section class="auth container">
        <h2>Авторизация</h2>
        <form action="{{URL::route('login')}}" method="post">
            {{Form::token()}}
            <input type="text" name="login" placeholder="Логин" />
            <input type="password" name="password" placeholder="Пароль" />
            <input type="submit" value="Вход" />
        </form>
    </section>
@stop
