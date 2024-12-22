<div class="" uk-sticky="sel-target: .uk-navbar-container;">
    <nav class="uk-navbar-container">
        <div class="uk-container ">
            <div uk-navbar>
                <div class="uk-navbar-left icon-sidebar">
                    <a class="uk-navbar-toggle icon-sidebar-a" uk-navbar-toggle-icon type="button" uk-toggle="target: #offcanvas-nav"></a>
                </div> 
                @if (!Auth::user())
                <div class="uk-navbar-left uk-hidden@s">
                    <a class="uk-navbar-toggle" uk-navbar-toggle-icon type="button" uk-toggle="target: #offcanvas-nav"></a>
                </div>  
                <div class="uk-navbar-left uk-visible@s">
                    <ul class="uk-navbar-nav">
                        <li class="uk-active"><a href="{{route('index')}}">Главная</a></li>
                    </ul>
                </div>
                @endif
                <div class="uk-navbar-right">
                    <ul class="uk-navbar-nav">
                        @if (Auth::user())
                        <li class="nav-profile">
                            <button class="uk-button uk-button-default" type="button">{{Auth::user()->name}}</button>
                            <div uk-dropdown>
                                <ul class="uk-nav uk-dropdown-nav">
                                    <li><a href="{{route('dashboard.index')}}">Рабочий стол</a></li>
                                    @if (Auth::user()->isadmin > 0)
                                        <li><a href="{{route('admin.index')}}">Админка</a></li>
                                    @endif
                                    <li><a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Выход</a></li>
                                    
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </ul>
                            </div>
                        </li>
                        @endif
                    </ul>
            
                </div>
            </div>
        </div>
    </nav>
</div>
<div id="offcanvas-nav" uk-offcanvas="overlay: true">
    <div class="uk-offcanvas-bar uk-flex uk-flex-column">
        <ul class="uk-nav uk-nav-primary uk-nav-center uk-margin-auto-vertical">
            
            @if (Auth::user())
            <li><a href="{{route('dashboard.index')}}"><span class="uk-margin-small-right"></span> Рабочий стол</a></li>
            <li><a href="{{route('dashboard.goldenCard.index')}}"><span class="uk-margin-small-right"></span> Золотая визитка</a></li>
            <li><a href="{{route('dashboard.key.index')}}"><span class="uk-margin-small-right"></span> Lida</a></li>
            <li><a href="{{route('dashboard.partner.index')}}"><span class="uk-margin-small-right"></span> Партнерка</a></li>
            @else
                <li><a href="{{route('login')}}"><span class="uk-margin-small-right"></span> Вход регистрация</a></li>
            @endif
        </ul>
    </div>
</div>