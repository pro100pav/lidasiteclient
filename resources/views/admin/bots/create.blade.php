@extends('template.admin', [
    'page' => 'Создание бота',
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
                    <form action="{{route('admin.bots.create')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Название</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="token">Токен</label>
                            <input type="text" id="token" name="token" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="link">Ссылка на бота</label>
                            <input type="text" id="link" name="link" class="form-control">
                        </div>
                        <button class="btn btn-success">Создать</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

@endsection
