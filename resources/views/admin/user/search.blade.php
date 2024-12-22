@extends('template.admin', [
    'page' => 'Результаты поиска',
])
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Пользователи</h4>
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
                @if ($users->count() < 0)
                    <h3>Не найднено</h3>
                @else
                    
                
                <div class="table-responsive">
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th style="width:80px;"><strong>id</strong></th>
                                <th><strong>Имя</strong></th>
                                <th><strong>username</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach ($users as $item)
                                <tr>
                                    <td><a href="{{route('admin.user.show',$item->id)}}"><strong>{{$item->id}}</strong></a></td>
                                    <td><a href="{{route('admin.user.show',$item->id)}}">{{$item->name}}</a></td>
                                    <td><a href="{{route('admin.user.show',$item->id)}}">{{$item->username}}</a></td>
                                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection