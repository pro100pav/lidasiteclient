@extends('template.admin', [
    'page' => 'Сценарий шаблона '.$temp->name,
])
@section('content')
<div class="row page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{route('admin.botconstr.index')}}">Назад</a></li>
    </ol>
</div>
<div class="row">
    <div class="col-12">
        <a href="javascript:void(0);" class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#createMessage">Создать сообщение</a>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Сообщения</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Название</th>
                                <th>Тригер</th>
                                <th>Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($temp->messages as $message)
                                    <tr>
                                        <td>
                                            {{ $message->id_message }}
                                        </td>
                                        <td>
                                            {{ $message->name }}
                                        </td>
                                        <td>
                                            {{ $message->trigger }}
                                        </td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="{{route('admin.botconstr.messageEdit', $message->id)}}">Редактировать</a>
                                            @if ($message->trigger != '/start')
                                                @if ($message->trigger != '/menu')
                                                <a class="btn btn-danger btn-sm" href="{{route('admin.botconstr.messageDelete', $message->id)}}">Удалить</a>
                                                @endif
                                                
                                            @endif
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
                <h5 class="modal-title">Создание сообщения</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form class="comment-form" method="POST" action="{{route('admin.botconstr.messageCreate',$temp->id )}}">
                    @csrf
                    <div class="row"> 
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Имя <span class="required">*</span></label>
                                <input type="text" class="form-control namemesages" value="" name="name" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Триггер сообщения (команда для быстрого перехода к сообщению)</label>
                                <input type="text" class="form-control trigmesages" value="" placeholder="" oninput='this.value=this.value.replace(/[^\w\d]*/gi,"");' maxlength="10" required name="trigger">
                                <p class="small">Только латинские буквы</p>
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="kandidat"
                                id="kandadd">
                            <label class="form-check-label" for="kandadd">
                                Список рефералов
                            </label>
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