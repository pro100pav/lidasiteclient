@extends('template.admin', [
    'page' => 'Пользователь ' . $user->name,
])
@section('content')
    @include('admin.component.userHead')
    <div class="row">
        @include('admin.component.userinfo')
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            @include('admin.component.usernav')
                            <div class="profile-personal-info">
                                <div class="profile-skills mt-3 mb-2">
                                    <h4 class="text-primary mb-2">Чаты</h4>
                                    @foreach($user->bots as $bot)
                                        @if($bot->chat)
                                            <a href="{{route('admin.user.chat',$bot->chat->id)}}" class="btn btn-primary light btn-xs mb-1">Чат в боте "{{$bot->bot->name}}"</a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


