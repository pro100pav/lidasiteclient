<div class="uk-width-1-5@m uk-padding-remove-left sidebar">
    <button class="sidebar-close-icon">
        <span class="uk-margin-small-right" uk-icon="close"></span>
    </button>
    <div class="uk-section uk-section-small uk-flex uk-flex-center uk-flex-middle">
        <div class="uk-container uk-container-small">
            <ul class="uk-list uk-list-divider uk-text-center">
                <li>
                    <a href="{{route('dashboard.index')}}" class="uk-button uk-button-primary uk-width-1-1 uk-flex uk-flex-middle">
                        <span uk-icon="icon: thumbnails"></span>
                        <span class="uk-margin-left">Рабочий стол</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('dashboard.goldenCard.index')}}" class="uk-button uk-button-primary uk-width-1-1 uk-flex uk-flex-middle">
                        <span uk-icon="icon: credit-card"></span>
                        <span class="uk-margin-left">Золотая визитка</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('dashboard.key.index')}}" class="uk-button uk-button-primary uk-width-1-1 uk-flex uk-flex-middle">
                        <span uk-icon="icon: server"></span>
                        <span class="uk-margin-left">LIDA</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('dashboard.partner.index')}}" class="uk-button uk-button-primary uk-width-1-1 uk-flex uk-flex-middle">
                        <span uk-icon="icon: users"></span>
                        <span class="uk-margin-left">Партнерка</span>
                    </a>
                </li>

                {{-- <li>
                    <a href="#" class="uk-button uk-button-primary uk-width-1-1 uk-flex uk-flex-middle">
                        <span uk-icon="icon: settings"></span>
                        <span class="uk-margin-left">Настройки</span>
                    </a>
                </li> --}}
                @if (Auth::user()->isadmin == 1)
                <li>
                    <a href="{{route('admin.index')}}" class="uk-button uk-button-primary uk-width-1-1 uk-flex uk-flex-middle">
                        <span uk-icon="icon: settings"></span>
                        <span class="uk-margin-left">Админка</span>
                    </a>
                </li>
                @endif
                
            </ul>
        </div>
    </div>
</div>
