@extends('template.admin', [
    'page' => 'Создание страницы',
])
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Содержимое</h3>
                </div>
                <div class="card-body" style="display: block;">
                    <form action="{{ route('admin.front.create') }}" method="post">
                        @csrf
                        
                        <div class="custom-form-floating mb-2">
                            <label for="">Название</label>
                            <input type="text" class="form-control" name="pagetitle" value="">
                        </div>
                        <div class="custom-form-floating mb-2">
                            <label for="">Название во вкладке</label>
                            <input type="text" class="form-control" name="longtitle" value="">
                        </div>
                        <div class="custom-form-floating mb-2">
                            <label for="">Описание</label>
                            <input type="text" class="form-control" name="description" value="">
                        </div>
                        <div class="custom-form-floating mb-2">
                            <label for="">ссылка</label>
                            <input type="text" class="form-control" name="slug" value="">
                        </div>

                        <div class="custom-form-floating mb-2">
                            <label for="">Текстовое содержимое курса</label>
                            <textarea id="summernote" class="form-control textareaElement" rows="3" name="editordata"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="type">Тип</label>
                            <select id="type" name="type" class="form-control custom-select">
                                <option value="1">Общая</option>
                                <option value="2">Оферта</option>
                            </select>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" name="ismenu" id="check1" value="" checked="">
                            <label class="form-check-label" for="check1">Показывать в меню</label>
                        </div>
                        <button class="btn btn-solid sendpoint" type="submit">Сохранить</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
