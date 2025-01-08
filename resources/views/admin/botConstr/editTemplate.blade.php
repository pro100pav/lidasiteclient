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
                <div class="d-none" id="templateid">{{$temp->id}}</div>
                <form action="{{route('admin.botconstr.editTemplate', $temp->id)}}" method="post">
                    @csrf
                    <input type="hidden" name="images" id="photomessage" value="{{$temp->images}}">
                    <input type="hidden" name="video" id="videomessage" value="{{$temp->video}}">
                    <input type="hidden" name="video_notice" id="videomessagenotice" value="{{$temp->video_notice}}">
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
                        <div class="row">
                            <div class="col-12"><h3 class="card-title">Настройки реферального бота</h3></div>
                            <div class="col-12">
                                <div class="custom-form-floating">
                                    <label for="ref_dostigenie">Сколько нужно набрать рефералов для срабатывания тригера</label>
                                    <input type="number" id="ref_dostigenie" name="ref_dostigenie" class="form-control" value="{{$temp->ref_dostigenie}}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="text-black font-w600 form-label">Сообщение при срабатывание триггера</label>
                                    <textarea class="form-control" name="ref_message" rows="6">{!!  $temp->ref_message !!}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <p class="resp"></p>
                                    <label for="">Картинка</label>
                                    <input class="choose-file form-file-input form-control" type="file" name="photo" id="messageImg">
                                </div>
                            </div>
                            @if (!$temp->video)
                                <div class="col-lg-12 videoMessage">
                                    <div class="mb-3">
                                        <p class="resVideo"></p>
                                        <div id="upload-container">
                                            <button id="browseFileAny" type="button" class="btn btn-primary formvideo">Выбрать видео</button>
                                        </div>
                                        <p>Только mp4 или avi не более 40 мегабайт</p>
                                    </div>
                                    <div class="progress progress-any mt-3" style="height: 25px">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                            role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 0%; height: 100%">
                                            0%</div>
                                    </div>
                                </div>
                            @endif
                            @if (!$temp->video_notice)
                                <div class="col-lg-12 videoMessage2">
                                    <div class="mb-3">
                                        <p class="resVideoNotice"></p>
                                        <div id="upload-container">
                                            <button id="browseFileSquare" type="button" class="btn btn-primary formvideo">Загрузить видео заметку (Кружок)</button>
                                        </div>
                                        <p>Не более 20 мб, квадратное, только mp4, кружочек сохраненный из избранного</p>
                                    </div>
                                    <div class="progress progress-square mt-3" style="height: 25px">
                                        <div class="progress-bar1 progress-bar-striped progress-bar-animated"
                                            role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 0%; height: 100%">
                                            0%</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button class="btn btn-success">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Прикрепленные медиа</h3>
                </div>
                <div class="row">
                    @if ($temp->images)
                        <div class="col-4">
                            <div class="attach text-center">
                                <img src="{{$temp->images}}" class="img-fluid" alt="">
                                <span class="deltempel" data-type-media="images">Удалить</span>
                            </div>
                        </div>
                    @endif
                    @if ($temp->video)
                        <div class="col-4">
                            <div class="attach">
                                <video src="{{ $temp->video }}" controls style="width: 100%; "></video>
                                <span class="deltempel" data-type-media="video">Удалить</span>
                            </div>
                        </div>
                    @endif
                    @if ($temp->video_notice)
                        <div class="col-4">
                            <div class="attach">
                                <video src="{{ $temp->video_notice }}" controls style="width: 100%; "></video>
                                <span class="deltempel" data-type-media="video_notice">Удалить</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
