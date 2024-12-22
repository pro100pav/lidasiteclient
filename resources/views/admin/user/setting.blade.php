@extends('template.admin', [
    'page' => 'Настройки юзера ' . $user->name,
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

                            <div class="pt-3">
                                <div class="settings-form">
                                    <h4 class="text-primary">Действия</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form method="POST" action="{{route('admin.user.setting', $user->id)}}">
                                                @csrf
                                                <input type="hidden" name="type" value="1">
                                                <div class="row">
                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label">Начислить на баланс для покупки</label>
                                                        <input type="text" placeholder="Сумма начисления" name="summa" class="form-control">
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Начислить</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <form method="POST" action="{{route('admin.user.setting', $user->id)}}">
                                                @csrf
                                                <input type="hidden" name="type" value="2">
                                                <div class="row">
                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label">Списать с баланса для покупки</label>
                                                        <input type="text" placeholder="Сумма списания" name="summa" class="form-control">
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Списать</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <form method="POST" action="{{route('admin.user.setting', $user->id)}}">
                                                @csrf
                                                <input type="hidden" name="type" value="3">
                                                <div class="row">
                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label">Начислить на баланс для вывода</label>
                                                        <input type="text" placeholder="Сумма начисления" name="summa" class="form-control">
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Начислить</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <form method="POST" action="{{route('admin.user.setting', $user->id)}}">
                                                @csrf
                                                <input type="hidden" name="type" value="4">
                                                <div class="row">
                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label">Списать с баланса для вывода</label>
                                                        <input type="text" placeholder="Сумма списания" name="summa" class="form-control">
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Списать</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <form method="POST" action="{{route('admin.user.setting', $user->id)}}">
                                                @csrf
                                                <input type="hidden" name="type" value="5">
                                                <div class="row">
                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label">Начислить рейтинг</label>
                                                        <input type="text" placeholder="Сумма начисления" name="summa" class="form-control">
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Начислить</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <form method="POST" action="{{route('admin.user.setting', $user->id)}}">
                                                @csrf
                                                <input type="hidden" name="type" value="6">
                                                <div class="row">
                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label">Списать рейтинг</label>
                                                        <input type="text" placeholder="Сумма списания" name="summa" class="form-control">
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Списать</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <form method="POST" action="{{route('admin.user.setting', $user->id)}}">
                                                @csrf
                                                <input type="hidden" name="type" value="7">
                                                <div class="row">
                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label">Сменить наставника</label>
                                                        <input type="text" placeholder="id наставника" name="id" class="form-control">
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Сменить</button>
                                            </form>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <form method="POST" action="{{route('admin.user.setting', $user->id)}}">
                                                @csrf
                                                <input type="hidden" name="type" value="9">
                                                <div class="row">
                                                    <div class="mb-3 col-md-12">
                                                        <label class="form-label">Сменить пароль</label>
                                                        <input type="text" placeholder="пароль" name="pass" class="form-control">
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Сохранить</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <form method="POST" action="{{route('admin.user.setting', $user->id)}}">
                                                @csrf
                                                <input type="hidden" name="type" value="8">
                                                <button class="btn btn-primary" type="submit">Перевести аккаунт в удаленные</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <form method="POST" action="{{route('admin.user.setting', $user->id)}}">
                                                @csrf
                                                <input type="hidden" name="type" value="10">
                                                <button class="btn btn-primary" type="submit">Сделать телеграм необязательным</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <form method="POST" action="{{route('admin.user.setting', $user->id)}}">
                                                @csrf
                                                <input type="hidden" name="type" value="11">
                                                <button class="btn btn-primary" type="submit">Поставить в турбо без распределения</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <form method="POST" action="{{route('admin.user.setting', $user->id)}}">
                                                @csrf
                                                <input type="hidden" name="type" value="12">
                                                <button class="btn btn-primary" type="submit">Удалить аккаунт полностью</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            
                                            @foreach ($user->predstart as $item)
                                            <div style="border: 1px solid">
                                                <form action="{{route('turbo.paypools', ['id'=>$item->pul,'userid'=>$user->id])}}" method="post">
                                                    @csrf
                                                    <p>Участие в пуле {{$item->pul}}</p>
                                                    <button class="btn btn-primary">
                                                        Участвовать
                                                    </button>
                                                </form>
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
