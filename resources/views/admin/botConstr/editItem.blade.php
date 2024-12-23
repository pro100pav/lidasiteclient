@extends('template.admin', [
    'page' => 'Сообщение',
])
@section('content')
<div class="row page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{route('admin.botconstr.index')}}">Шаблоны</a></li>
        <li class="breadcrumb-item active"><a href="{{route('admin.botconstr.templateShow',$message->messageParent->bot_template_id)}}">Все блоки</a></li>
        <li class="breadcrumb-item active"><a href="{{route('admin.botconstr.messageEdit',$message->messageParent->id)}}">Сообщение</a></li>
    </ol>
</div>
<div class="row">

    <div class="col-12">
        <div class="card card-secondary">
            <div class="card-body">
                <div class="d-none" id="mesid">{{$message->id}}</div>
                <div class="col-12">
                    <p class="m-0">%name% - Обращение к собеседнику чата по имени</p>
                    {{-- <p class="m-0">%userreflink% - Реф ссылка пользователя</p> --}}
                    {{-- <p class="m-0">%id% - Id пользователя</p>
                    <p class="m-0">%referuser% - Пригласитель</p>
                    <p class="m-0">%countine% - Колличество в первой линии</p> --}}
                    <p class="m-0">%alluser% - Колиичество пользователей всего в этом боте</p>

                </div>
                <form class="comment-form" method="POST" action="{{route('admin.botconstr.messageItemEditSave', $message->id)}}">
                    @csrf
                    <input type="hidden" name="messageid" value="{{$message->bot_message_id}}">
                    <input type="hidden" name="photomessage" id="photomessage" value="{{$message->images}}">
                    <input type="hidden" name="videomessage" id="videomessage" value="{{$message->video}}">
                    <input type="hidden" name="videomessagenotice" id="videomessagenotice" value="{{$message->video_notice}}">
                    <div class="row"> 
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Текст <span class="required">*</span></label>
                                <textarea class="form-control" name="text" rows="6" id="text">{!!  $message->message !!}</textarea>
                                <p class="small">Символов <span id="counttext">0</span></p>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <p class="resp"></p>
                                <label for="">Картинка</label>
                                <input class="choose-file form-file-input form-control" type="file" name="photo" id="messageImg">
                            </div>
                        </div>
                        @if (!$message->video)
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
                        @if (!$message->video_notice)
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
                        
                        

                        <div class="col-lg-12">
                            <div class="mb-3 mb-0">
                                <input type="submit" value="Сохранить" class="submit btn btn-primary" name="submit">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    @if ($message->images)
                        <div class="col-4">
                            <div class="attach text-center">
                                <img src="{{$message->images}}" class="img-fluid" alt="">
                                <span class="delmesel" data-type-media="images">Удалить</span>
                            </div>
                        </div>
                    @endif
                    @if ($message->video)
                        <div class="col-4">
                            <div class="attach">
                                <video src="{{ $message->video }}" controls style="width: 100%; "></video>
                                <span class="delmesel" data-type-media="video">Удалить</span>
                            </div>
                        </div>
                    @endif
                    @if ($message->video_notice)
                        <div class="col-4">
                            <div class="attach">
                                <video src="{{ $message->video_notice }}" controls style="width: 100%; "></video>
                                <span class="delmesel" data-type-media="video_notice">Удалить</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@endsection