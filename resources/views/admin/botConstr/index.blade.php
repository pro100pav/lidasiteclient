@extends('template.admin', [
    'page' => 'Сценарии ботов',
])
@section('content')
<div class="row">
    <div class="col-12">
        <a href="javascript:void(0);" class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#createMessage">Создать сценарий</a>
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
                                <th>Название</th>
                                <th>Описание</th>
                                <th>Чат бот</th>
                                <th>Дата создания</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($botTemp as $item)
                                    <tr>
                                        <td>
                                            {{ $item->name }}
                                        </td>
                                        <td>
                                            {{ $item->description }}
                                        </td>
                                        <td>
                                            @if ($item->bot)
                                                {{ $item->bot->name }}
                                            @else
                                                Чат бот не подключен
                                            @endif
                                            
                                        </td>
                                        <td>
                                            {{ Carbon\Carbon::parse($item->created_at)->format('d.m.Y') }}
                                        </td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="{{route('admin.botconstr.templateShow', $item->id)}}">Настроить сценарий</a>
                                            <a class="btn btn-primary btn-sm" href="{{route('admin.botconstr.editTemplate', $item->id)}}">Редактировать</a>
                                            <a class="btn btn-danger btn-sm" href="{{route('admin.botconstr.deleteTemplate', $item->id)}}">Удалить</a>
                                            @if ($item->active == 0)
                                                <a class="btn btn-secondary btn-sm" href="{{route('admin.botconstr.templateActivate', $item->id)}}">Активировать</a>
                                            @else
                                                Этот сценарий запущен
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
                <h5 class="modal-title">Создание сценария</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form class="comment-form" method="POST" action="{{route('admin.botconstr.templateCreate')}}">
                    @csrf
                    <div class="row"> 
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Имя <span class="required">*</span></label>
                                <input type="text" class="form-control" value="" name="name">
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Описание</label>
                                <input type="text" class="form-control" value="" placeholder="" name="description">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">К какому чат боту будет првязан</label>
                                <select class="default-select form-control wide mb-3" name="bot" required>
                                    @foreach ($bots as $bot)
                                        <option value="{{$bot->id}}">{{$bot->name}}</option>
                                    @endforeach
                                </select>
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