@extends('template.admin', [
    'page' => 'редактирование бота',
])
@section('content')
<div class="row page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{route('admin.bots.index')}}">Назад</a></li>
    </ol>
</div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Общее</h3>
                </div>
                <div class="card-body" style="display: block;">
                    <form action="{{route('admin.bots.edit', $bot->id)}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Название</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{$bot->name}}">
                        </div>
                        <div class="form-group">
                            <label for="token">Токен</label>
                            <input type="text" id="token" name="token" class="form-control" value="{{$bot->token}}">
                        </div>
                        
                        <div class="form-group">
                            <label for="link">Ссылка на бота</label>
                            <input type="text" id="link" name="link" class="form-control" value="{{$bot->link}}">
                        </div>
                        <button class="btn btn-success">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
