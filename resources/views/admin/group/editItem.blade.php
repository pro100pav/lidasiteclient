@extends('template.admin', [
    'page' => 'Сообщение',
])
@section('content')
<div class="row">

    <div class="col-12">
        <div class="card card-secondary">
            <div class="card-body">
                <div class="col-12">
                    <p class="m-0">%name% - Обращение к собеседнику чата по имени</p>
                    <p class="m-0">%userreflink% - Реф ссылка пользователя</p>
                    <p class="m-0">%userid% - Id пользователя</p>
                    <p class="m-0">%status% - статус пользователя</p>
                    <p class="m-0">%activate% - активен ли пользовател</p>
                    <p class="m-0">%balance% - Баланс пользователя</p>
                    <p class="m-0">%balanceWork% - Сколько заработанно</p>
                    <p class="m-0">%referer% - Пригласитель юзера</p>
                    <p class="m-0">%alluser% - Сколько всего пользователей</p>
                </div>
                <form class="comment-form" method="POST" action="{{route('admin.trbot.messageItemEdit', $message->id)}}">
                    @csrf
                    <input type="hidden" name="messageid" value="{{$message->messageParent->id}}">
                    <input type="hidden" name="photomessage" id="photomessage" value="{{$message->images}}">
                    <input type="hidden" name="videomessage" id="videomessage" value="{{$message->video}}">
                    <div class="row"> 
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Текст <span class="required">*</span></label>
                                <textarea class="form-control" name="text" rows="6">{!!  $message->message !!}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <p class="resp"></p>
                                <label for="">Картинка</label>
                                <input class="choose-file form-file-input form-control" type="file" name="photo" id="messageImg">
                            </div>
                        </div>
                        <div class="col-lg-12 videoMessage">
                            <div class="mb-3">
                                <p class="res"></p>
                                <div id="upload-container">
                                    <button id="browseFile" type="button" class="btn btn-primary formvideo">Выбрать видео</button>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 25px">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%; height: 100%">
                                    75%</div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <select class="default-select form-control wide mb-3" name="function">
                                    <option value="0">Без функции</option>
                                    <option value="referals" @if ($message->function == 'referals') selected @endif>Список рефералов первой линии</option>
                                    <option value="surprise" @if ($message->function == 'surprise') selected @endif>Подарочные посты с рефералкамй</option>
                                    <option value="podpiska" @if ($message->function == 'podpiska') selected @endif>Проверка подписки на каналы</option>
                                    <option value="auth"     @if ($message->function == 'auth') selected @endif>Вход в кабинет</option>
                                    <option value="visitka"  @if ($message->function == 'visitka') selected @endif>Моя визитка</option>
                                    <option value="createpost" @if ($message->function == 'createpost') selected @endif>Создание поста</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Сообщение приклеено к видео или картинке (0 нет, 1 да)</label>
                                <input type="text" class="form-control" value="0" placeholder="" name="fixed" value="{{$message->fixed}}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3 mb-0">
                                <input type="submit" value="Сохранить" class="submit btn btn-primary" name="submit">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-6">
                        @if ($message->images)
                            <img src="{{$message->images}}" class="img-fluid" alt="">
                        @endif
                    </div>
                    <div class="col-6">
                        @if ($message->video)
                            <video src="{{ $message->video }}" controls style="width: 100%; "></video>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection