@extends('template.admin', [
    'page' => 'Группы',
])
@section('content')
    <div class="row">
        <div class="col-12">
            <a href="javascript:void(0);" class="btn btn-success mb-1" data-bs-toggle="modal"
                data-bs-target="#createMessage">Добавить настройку для групп</a>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Группы</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Название</th>
                                    <th>Активность</th>
                                    <th>Действие</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groups as $item)
                                    <tr>
                                        <td>
                                            {{ $item->group_id }}
                                        </td>
                                        <td>
                                            {{ $item->group_name }}
                                        </td>
                                        <td>
                                            <a class="btn btn-danger btn-sm" href="">Отписать бота от группы</a>
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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Настройки групп</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Название</th>
                                    <th>Активность</th>
                                    <th>Действие</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($settings as $set)
                                    <tr>
                                        <td>
                                            {{ $set->name }}
                                        </td>
                                        <td>
                                            {{ $set->description }}
                                        </td>
                                        <td>
                                            {{ $set->type }}
                                        </td>
                                        <td>
                                            {{ $set->params }}
                                        </td>
                                        <td>
                                            <a class="btn btn-danger btn-sm" href="">Редактировать</a>
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


    <div class="modal fade" id="createMessage">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Добавление</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form class="comment-form" method="POST" action="{{route('admin.groupSett.create')}}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="text-black font-w600 form-label">Название</label>
                                    <input type="text" class="form-control" placeholder="" name="name">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="text-black font-w600 form-label">Описание</label>
                                    <input type="text" class="form-control" placeholder="" name="description">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="text-black font-w600 form-label">Тип</label>
                                    <input type="text" class="form-control" placeholder="" name="type">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="text-black font-w600 form-label">Параметры</label>
                                    <input type="text" class="form-control" placeholder="" name="params">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <div class="form-check custom-checkbox mb-3">
                                        <input type="checkbox" class="form-check-input" name="public" id="public"
                                            checked>
                                        <label class="form-check-label" for="public">Активен</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3 mb-0">
                                    <input type="submit" value="Добавить" class="submit btn btn-primary" name="submit">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
