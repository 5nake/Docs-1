@section('content')
    <img src="{{URL::route('stream', $file->token)}}" style="
        padding: 20px 0;
        width: {{$width}}px;
        height: {{$height}}px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin: -{{$height/2 + 20}}px 0 0 -{{$width/2}}px;
        box-shadow:
            0 0 0 1px rgba(0, 0, 90, .1),
            0 0 0 3px #fff,
            0 0 15px 3px rgba(0, 0, 0, .4);
    " />
@stop
