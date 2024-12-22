@extends('template.admin', [
    'page' => 'Редактирование проекта',
])
@section('content')
<div class="row">

    <div class="col-12">
        <div class="card card-secondary">
            <div class="card-body">
                <form class="comment-form" method="POST" action="{{route('admin.project.edit', $project->id)}}">
                    @csrf
                    <div class="row"> 
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Название</label>
                                <input type="text" class="form-control" value="{{$project->name}}" name="name">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Ссылка на проект</label>
                                <input type="text" class="form-control" value="{{$project->link}}" name="link">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Метод</label>
                                <input type="text" class="form-control" value="{{$project->method}}" name="method">
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <div class="form-check custom-checkbox mb-3">
                                    <input type="checkbox" class="form-check-input" name="public" id="public" @if ($project->active == 1)checked @endif>
                                    <label class="form-check-label" for="public">Активен</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3 mb-0">
                                <input type="submit" value="Сохранить" class="submit btn btn-primary" name="submit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection