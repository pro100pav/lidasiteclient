@extends('template.admin', [
    'page' => 'Сообщение',
])
@section('content')
<div class="row">
    <div class="col-12">
        <a href="javascript:void(0);" class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#createMessage">Добавить в сообщение элемент</a>
    </div>
    @foreach ($message->items as $item)
    <div class="col-12">
        <div class="card card-secondary">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        @if ($item->images)
                            <img src="{{$item->images}}" class="img-fluid" alt="">
                        @endif
                    </div>
                    <div class="col-6">
                        @if ($item->video)
                            <video src="{{ $item->video }}" controls style="width: 100%; "></video>
                        @endif
                    </div>
                    <div class="col-12">
                        <p>{!! \preg_replace( "#\r?\n#", "<br />", $item->message )!!}</p>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            @foreach ($item->buttons as $button)
                                <div class="col-6">
                                    <div class="mb-2 position-relative" style="border: 1px solid #6e6d6d; border-radius:5px; text-align: center;">
                                        <p class="m-0">{{$button->text}}</p>
                                        <a href="{{route('admin.trbot.messageButtonDelete', $button->id)}}" class="delbtn" style="position: absolute;top: 0;right: 40px;font-size:1rem;"><i class="fa fa-trash"></i></a>
                                        <a href="javascript:void(0);" class="editbtn" style="position: absolute;top: 0;right: 10px;font-size:1rem;"  data-bs-toggle="modal" data-item-id="{{$item->id}}" data-item-idbut="{{$button->id}}" data-item-text="{{$button->text}}" data-item-type="{{$button->type_button}}" data-item-callback="{{$button->callback_button}}" data-bs-target="#createButton"><i class="fa fa-pencil-square-o"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                    </div>
                    <div class="col-12">
                        <a href="javascript:void(0);" class="btn btn-success mb-1 createbut" data-bs-toggle="modal" data-item-id="{{$item->id}}" data-bs-target="#createButton">Добавить Кнопку</a>
                    </div>
                    <div class="col-12">
                        <a href="{{route('admin.trbot.messageItemEdit', $item->id)}}" class="btn btn-success btn-xs">Редактировать этот элмент</a>
                        <a href="{{route('admin.trbot.messageItemDelete', $item->id)}}" class="btn btn-danger btn-xs">Удалить этот элемент полностью</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>


<div class="modal fade" id="createMessage">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Создание айтема</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body ">
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
                <form class="comment-form" method="POST" action="{{route('admin.trbot.messageItemCreate')}}">
                    <input type="hidden" name="messageid" value="{{$message->id}}">
                    <input type="hidden" name="photomessage" id="photomessage">
                    <input type="hidden" name="videomessage" id="videomessage">
                    @csrf
                    <div class="row"> 
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Текст <span class="required">*</span></label>
                                <textarea class="form-control" name="text" rows="4"></textarea>
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
                        {{-- <div class="col-lg-12">
                            <div class="mb-3">
                                <select class="default-select form-control wide mb-3" name="typeButton">
                                    <option value="0">Без кнопок</option>
                                    <option value="1">Кнопки под сообщением</option>
                                    <option value="2">Кнопки где диалог</option>
                                </select>
                            </div>
                        </div> --}}
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <select class="default-select form-control wide mb-3" name="function">
                                    <option value="0">Без функции</option>
                                    <option value="referals">Список рефералов первой линии</option>
                                    <option value="surprise">Подарочные посты с рефералкамй</option>
                                    <option value="podpiska">Проверка подписки на каналы</option>
                                    <option value="auth">Вход в кабинет</option>
                                    <option value="visitka">Моя визитка</option>
                                    <option value="createpost">Создание поста</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Сообщение приклеено к видео или картинке (0 нет, 1 да)</label>
                                <input type="text" class="form-control" value="0" placeholder="" name="fixed">
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
<div class="modal fade" id="createButton">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Создание Кнопки</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body ">
                <form class="comment-form" method="POST" id="butform" action="{{route('admin.trbot.messageButtonCreate')}}">
                    <input type="hidden" name="itemid" value="" id="itemid">
                    <input type="hidden" name="editiid" value="0" id="editiid">
                    @csrf
                    <div class="row"> 
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Текст на кнопке</label>
                                <input type="text" class="form-control" value="" placeholder="" name="textbutton">
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Какое сообщение должен прислать</label>
                                <select class="form-control mb-3" id="optionBut" name="callbackMessage">
                                    <option value="0">Не указанно</option>
                                    @foreach ($messageAll as $mesit)
                                        <option value="{{$mesit->id_message}}">{{$mesit->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="text-black font-w600 form-label">Указать в ручную поведение кнопки (ссылка)</label>
                                <input type="text" class="form-control" value="" placeholder="" name="callback">
                                <p class="small">Если кнопка должна быть реферальной то указать ref</p>
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="mb-3 mb-0">
                                <input type="submit" value="Создать" class="submit btn btn-primary cre" name="submit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection