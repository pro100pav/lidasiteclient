<ul class="nav nav-tabs">
    <li class="nav-item"><a href="{{route('admin.user.show', $user->id)}}" class="nav-link @if(Route::is('admin.user.show', $user->id)) active show @endif">О пользователе</a></li>
    <li class="nav-item"><a href="{{route('admin.user.chats', $user->id)}}" class="nav-link @if(Route::is('admin.user.chats', $user->id)) active show @endif">Чаты с пользователем</a></li>
</ul>