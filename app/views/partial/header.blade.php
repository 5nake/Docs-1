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
