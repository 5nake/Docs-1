<header>
    <section class="middle" data-controller="HeaderController">
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

        <div class="memory-indicator">
            <div class="memory-indicator-content">
                <div class="memory-indicator-line-in" data-bind="attr: {
                    style: 'width:' + (volume()/maxVolume()*100) + '%'
                }"></div>
            </div>
            <span>
                Дисковая квота:
                <!--ko text: (volume()/1024/1024).toFixed(2) + 'Mb'-->
                <!--/ko--> / <!--ko text: (maxVolume()/1024/1024).toFixed(2) + 'Mb'-->
                <!--/ko-->
            </span>
        </div>
        @endif
    </section>
</header>
