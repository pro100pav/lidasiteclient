@extends('template.admin', [
    'page' => 'редактирование шаблона',
])
@section('content')
<div class="row page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{route('admin.botconstr.index')}}">Назад</a></li>
    </ol>
</div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Общее</h3>
                </div>
                <form action="{{route('admin.botconstr.editTemplate', $temp->id)}}" method="post">
                    @csrf
                    <div class="card-body" style="display: block;">
                        
                        <div class="custom-form-floating">
                            <label for="name">Название</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{$temp->name}}">
                        </div>
                        <div class="custom-form-floating">
                            <label for="description">Описание</label>
                            <input type="text" id="description" name="description" class="form-control" value="{{$temp->description}}">
                        </div>
                        
                        <div class="custom-form-floating">
                            <label for="username">Бот</label>
                            <select class="default-select form-control wide mb-3" name="bot">
                                <option value="0">-----</option>
                                @foreach ($bots as $bot)
                                    <option value="{{$bot->id}}" @selected($temp->bot_id == $bot->id)>{{$bot->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="custom-form-floating">
                            <label for="username">Доступ к боту</label>
                            <select class="default-select form-control wide mb-3" name="privat">
                                <option value="0" @if ($temp->privat == '0') selected @endif>Доступен всем</option>
                                <option value="1" @if ($temp->privat == '1') selected @endif>Доступен только после подписки на группы</option>
                            </select>
                        </div>
                        <div class="row">
                        <div class="col-12"><p>Если доступ к боту, включен, "Доступен только после подписки на группы", то необходимо отметить группы на которые нужно будет подписаться пользователю</p></div>
                        @foreach ($groups as $group)
                            <div class="col-xl-4 col-xxl-6 col-6">
                                <div class="form-check custom-checkbox mb-3">
                                    <input type="checkbox" class="form-check-input" name="group[]" id="group{{$loop->iteration}}" value="{{$group->id}}" @if($temp->groups->contains($group))checked @endif>
                                    <label class="form-check-label" for="group{{$loop->iteration}}">{{$group->group_name}}</label>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Сообщение со спиком групп для подписки <span class="required">*</span></label>
                                <textarea class="form-control" name="message" rows="6">{!!  $temp->message !!}</textarea>
                            </div>
                        </div>
                        </div>
                        <button class="btn btn-success">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
