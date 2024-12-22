@extends('template.admin', [
    'page' => 'Все пользователи',
])
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Все пользователи</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h4>Поиск</h4>
                    </div>
                    <div class="col-3">
                        <h6>Поиск по id</h6>
                        <form method="POST" action="{{route('admin.user.search')}}">
                            @csrf
                            <input type="hidden" name="type" value="1">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">id юзера</label>
                                    <input type="text" name="id" class="form-control">
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Найти</button>
                        </form>
                    </div>
                    <div class="col-3">
                        <h6>Поиск по username</h6>
                        <form method="POST" action="{{route('admin.user.search')}}">
                            @csrf
                            <input type="hidden" name="type" value="2">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Юзернейм</label>
                                    <input type="text" name="username" class="form-control">
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Найти</button>
                        </form>
                    </div>
                    <div class="col-3">
                        <h6>Поиск по ФИО</h6>
                        <form method="POST" action="{{route('admin.user.search')}}">
                            @csrf
                            <input type="hidden" name="type" value="3">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Имя фамилия</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Найти</button>
                        </form>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-responsive-md">
                        <thead>
                            <tr>
                                <th>
                                    <a href="{{ route('admin.user.index', ['sort' => 'id', 'direction' => $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                        ID
                                        @if($sortField == 'id')
                                            @if($sortDirection == 'asc')
                                                <i class="bi bi-arrow-up"></i>
                                            @else
                                                <i class="bi bi-arrow-down"></i>
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('admin.user.index', ['sort' => 'name', 'direction' => $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                        Имя
                                        @if($sortField == 'name')
                                            @if($sortDirection == 'asc')
                                                <i class="bi bi-arrow-up"></i>
                                            @else
                                                <i class="bi bi-arrow-down"></i>
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th><strong>Username</strong></th>
                                
                                <th>
                                    <a href="{{ route('admin.user.index', ['sort' => 'created_at', 'direction' => $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                                        Дата регистрации
                                        @if($sortField == 'created_at')
                                            @if($sortDirection == 'asc')
                                                <i class="bi bi-arrow-up"></i>
                                            @else
                                                <i class="bi bi-arrow-down"></i>
                                            @endif
                                        @endif
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td><a href="{{route('admin.user.show',$user->id)}}"><strong>{{$user->id}}</strong></a></td>
                                    <td><a href="{{route('admin.user.show',$user->id)}}">{{$user->name}}</a></td>
                                    <td><a href="{{route('admin.user.show',$user->id)}}">{{$user->username}}</a></td>
                                    <td>{{ $user->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->links('pagination.bootstrap') }}
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection