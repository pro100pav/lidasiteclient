@extends('template.admin', [
    'page' => 'Подарочные посты в боте',
])
@section('content')
<div class="row">
    <div class="col-12">
        <a href="javascript:void(0);" class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#createMessage">Создать пост</a>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Посты</h4>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Название</th>
                                <th>ссылка</th>
                                <th>Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $item)
                                    <tr>
                                        <td>
                                            {{ $item->id }}
                                        </td>
                                        <td>
                                            {{ $item->name }}
                                        </td>
                                        <td>
                                            {{ $item->link }}
                                        </td>
                                        <td>
                                            <a class="btn btn-danger btn-sm" href="{{route('admin.trbot.surpriseEdit', $item->id)}}">Редактировать</a>
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
                <h5 class="modal-title">Создание</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form class="comment-form" method="POST" action="{{route('admin.trbot.surpriseCreateSave')}}">
                    @csrf
                    <div class="row"> 
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Название</label>
                                <input type="text" class="form-control"  placeholder="" name="name">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Ссылка на проект</label>
                                <input type="text" class="form-control"  placeholder="" name="link">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Текст <span class="required">*</span></label>
                                <textarea class="form-control" name="text" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Ссылка на картинку</label>
                                <input type="text" class="form-control"  placeholder="" name="images">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Ссылка кнопка</label>
                                <input type="text" class="form-control"  placeholder="" name="button">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">верификация ссылки для пользователей</label>
                                <input type="text" class="form-control"  placeholder="" name="buttonVerification">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <div class="form-check custom-checkbox mb-3">
                                    <input type="checkbox" class="form-check-input" name="public" id="public" checked>
                                    <label class="form-check-label" for="public">Опубликован</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <select class="default-select form-control wide mb-3" name="integration">
                                            <option value="0">Без интеграции</option>
                                            <option value="1">Интегрируется с кликом</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3 mb-0">
                                <input type="submit" value="Создать" class="submit btn btn-primary" name="submit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection