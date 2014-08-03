@section('content')
    <section class="error-content">
        <h1>{{$message}}</h1>
        <a href="{{URL::route('home')}}">На главную</a>
    </section>
@stop
