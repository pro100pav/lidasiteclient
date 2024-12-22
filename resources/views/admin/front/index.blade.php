@extends('template.admin', [
    'page' => 'Страница фронта',
])
@section('content')
<div class="row">
    <div class="col-12">
        <a href="{{route('admin.front.create')}}" class="btn btn-success">Создать страницу</a>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Все страницы</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pages as $page)
                                    <tr>
                                        <td>
                                            {{ $page->pagetitle }}
                                        </td>
                                        <td>
                                            <a class="btn btn-danger btn-sm" href="{{route('admin.front.delete', $page->id)}}">Удалить</a>
                                        </td>
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection