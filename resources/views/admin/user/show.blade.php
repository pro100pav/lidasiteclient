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
                                <h4 class="text-primary mb-4">Информация</h4>
                                <p>id: {{ $user->id }}</p>
                                <p>id телеграм: {{ $user->id_telegram }}</p>
                                <p>юзернейм: {{ $user->username }}</p>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header d-block">
                                        <h4 class="card-title">Струтура пользователя</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="accordion accordion-primary" id="accordion-one">
                                            
                                            @foreach ($user->bots as $item)
                                            <div class="accordion-item">
                                                <div class="accordion-header collapsed rounded-lg" id="heading{{$loop->iteration}}"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse{{$loop->iteration}}"
                                                    aria-controls="collapse{{$loop->iteration}}" role="button" aria-expanded="true">
                                                    <span class="accordion-header-text">{{$item->bot->name}}</span>
                                                    <span class="accordion-header-indicator"></span>
                                                </div>
                                                <div id="collapse{{$loop->iteration}}" class="collapse" aria-labelledby="heading{{$loop->iteration}}"
                                                    data-bs-parent="#accordion-one">
                                                    <div class="accordion-body-text">
                                                        <div class="profile-skills mt-3 mb-2">
                                                            <h4 class="text-primary mb-2">Наставники</h4>
                                                            @foreach ($user->breadcrumbspartner($item->bot_id)->reverse() as $partner)
                                                                <a href="{{route('admin.user.show', $partner->user->id)}}" class="btn btn-primary light btn-xs mb-1">@if ($partner->user->name){{$partner->user->name}}@else {{$partner->user->id}}@endif</a>
                                                            @endforeach
                                                        </div>
                                                        <div class="profile-skills mt-3 mb-2">
                                                            <h4 class="text-primary mb-2">Рефералы ({{$user->partner->where('bot_id', $item->bot_id)->first()->partner->count()}})</h4>
                                                            
                                                            @foreach ($user->partner->where('bot_id', $item->bot_id)->first()->partner as $partner)
                                                                <a href="{{route('admin.user.show', $partner->user->id)}}" class="btn btn-primary light btn-xs mb-1">@if ($partner->user->name){{$partner->user->name}}@else {{$partner->user->id}}@endif</a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
