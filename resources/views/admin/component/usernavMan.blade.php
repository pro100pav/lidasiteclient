<ul class="nav nav-tabs">
    <li class="nav-item"><a href="{{route('admin.user.managerShow', $userMan->id)}}" class="nav-link @if(Route::is('admin.user.managerShow', $userMan->id)) active show @endif">О пользователе</a></li>
    <li class="nav-item"><a href="{{route('admin.user.managerChats', $userMan->id)}}" class="nav-link @if(Route::is('admin.user.managerChats', $userMan->id)) active show @endif">Чаты менеджера</a></li>
</ul>