<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a class="has-arrow ai-icon" href="{{route('admin.user.index')}}" aria-expanded="false">
                    <i class="flaticon-025-dashboard"></i>
                    <span class="nav-text">Пользователи</span>
                </a>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                <i class="flaticon-050-info"></i>
                    <span class="nav-text">Чат боты</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('admin.bots.index')}}">Все боты</a></li>
                    <li><a href="{{route('admin.botconstr.index')}}">Сценарий бота</a></li>
                    <li><a href="{{route('admin.groups.index')}}">Группы</a></li>
                    <li><a href="{{route('admin.rassilka.index')}}">Рассылка</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>