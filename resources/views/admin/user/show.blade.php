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
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
