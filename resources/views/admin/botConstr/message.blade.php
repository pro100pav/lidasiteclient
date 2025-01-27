@extends('template.admin', [
    'page' => 'Сообщение',
])
@section('content')
    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{ route('admin.botconstr.index') }}">Шаблоны</a></li>
            <li class="breadcrumb-item active"><a
                    href="{{ route('admin.botconstr.templateShow', $message->bot_template_id) }}">Все блоки</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="card-body">
            <ul class="nav nav-pills mb-4 light">
                <li class=" nav-item">
                    <a href="#navpills-1" class="nav-link active" data-bs-toggle="tab" aria-expanded="false">Элементы
                        сообщения</a>
                </li>
                <li class="nav-item">
                    <a href="#navpills-2" class="nav-link" data-bs-toggle="tab" aria-expanded="false">Настройки
                        сообщения</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="navpills-1" class="tab-pane active">
                    <div class="col-12">
                        <a href="javascript:void(0);" class="btn btn-success mb-1" data-bs-toggle="modal"
                            data-bs-target="#createMessage">Добавить в сообщение элемент</a>
                    </div>
                    @foreach ($message->items as $item)
                        <div class="col-12">
                            <div class="card card-secondary">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            @if ($item->images)
                                                <img src="{{ $item->images }}" class="img-fluid" alt="">
                                            @endif
                                        </div>

                                        <div class="col-12">
                                            <p>{!! \preg_replace("#\r?\n#", '<br />', $item->message) !!}</p>
                                        </div>
                                        <div class="col-12">
                                            @if ($item->function == 'referals')
                                                <p class="h3">Это сообщение выводит список рефералов пользователя</p>
                                            @endif
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                @foreach ($item->buttons as $button)
                                                    <div class="col-6">
                                                        <div class="mb-2 position-relative"
                                                            style="border: 1px solid #6e6d6d; border-radius:5px; text-align: center;">
                                                            <p class="m-0">{{ $button->text }}</p>
                                                            <a href="{{ route('admin.botconstr.messageButtonDelete', $button->id) }}"
                                                                class="delbtn"
                                                                style="position: absolute;top: 0;right: 40px;font-size:1rem;"><i
                                                                    class="fa fa-trash"></i></a>
                                                            <a href="javascript:void(0);" class="editbtn"
                                                                style="position: absolute;top: 0;right: 10px;font-size:1rem;"
                                                                data-bs-toggle="modal" data-item-id="{{ $item->id }}"
                                                                data-item-idbut="{{ $button->id }}"
                                                                data-item-text="{{ $button->text }}"
                                                                data-item-type="{{ $button->type_button }}"
                                                                data-item-callback="{{ $button->callback_button }}"
                                                                data-bs-target="#createButton"><i
                                                                    class="fa fa-pencil-square-o"></i></a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>
                                        <div class="col-12">
                                            <a href="javascript:void(0);" class="btn btn-success mb-1 createbut"
                                                data-bs-toggle="modal" data-item-id="{{ $item->id }}"
                                                data-bs-target="#createButton">Добавить Кнопку</a>
                                        </div>
                                        <div class="col-12">
                                            <a href="{{ route('admin.botconstr.messageItemEdit', $item->id) }}"
                                                class="btn btn-success btn-xs">Редактировать этот элмент</a>
                                            <a href="{{ route('admin.botconstr.messageItemDelete', $item->id) }}"
                                                class="btn btn-danger btn-xs">Удалить этот элемент полностью</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="navpills-2" class="tab-pane">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Общее</h3>
                        </div>
                        <form action="{{ route('admin.botconstr.editMessage', $message->id) }}" method="post">
                            @csrf
                            <div class="card-body" style="display: block;">

                                <div class="custom-form-floating">
                                    <label for="username">Доступ к сообщению</label>
                                    <select class="default-select form-control wide mb-3" name="privat">
                                        <option value="0" @if ($message->privat == '0') selected @endif>Доступно
                                            всем</option>
                                        <option value="1" @if ($message->privat == '1') selected @endif>Доступно
                                            только после подписки на группы</option>
                                    </select>
                                </div>
                                <div class="row">
                                    @foreach ($groups as $group)
                                        <div class="col-xl-4 col-xxl-6 col-6">
                                            <div class="form-check custom-checkbox mb-3">
                                                <input type="checkbox" class="form-check-input" name="group[]"
                                                    id="group{{ $loop->iteration }}" value="{{ $group->id }}"
                                                    @if ($message->groups->contains($group)) checked @endif>
                                                <label class="form-check-label"
                                                    for="group{{ $loop->iteration }}">{{ $group->group_name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="text-black font-w600 form-label">Сообщение со спиком групп для
                                                подписки <span class="required">*</span></label>
                                            <textarea class="form-control" name="message" rows="6">{!! $message->message !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-success">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                        <p class="m-0">%name% - Обращение к собеседнику чата по имени и фамилии</p>
                        <p class="m-0">%userreflink% - Реф ссылка пользователя</p>
                        <p class="m-0">%id% - Id пользователя</p>
                        <p class="m-0">%referuser% - Пригласитель</p>
                        <p class="m-0">%countine% - Колличество в первой линии</p>
                        <p class="m-0">%alluser% - Колиичество пользователей всего в этом боте</p>
                    </div>
                    <form class="comment-form" method="POST"
                        action="{{ route('admin.botconstr.messageItemCreate', $message->id) }}">
                        <input type="hidden" name="messageid" value="{{ $message->id }}">
                        <input type="hidden" name="photomessage" id="photomessage">
                        <input type="hidden" name="videomessage" id="videomessage">
                        <input type="hidden" name="videomessagenotice" id="videomessagenotice" >
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="text-black font-w600 form-label">Текст <span
                                            class="required">*</span></label>
                                    <textarea class="form-control" name="text" id="text" rows="4"></textarea>
                                    <p class="small">Символов <span id="counttext">0</span></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <p class="resp"></p>
                                    <label for="">Картинка</label>
                                    <input class="choose-file form-file-input form-control" type="file" name="photo"
                                        id="messageImg">
                                </div>
                            </div>
                            <div class="col-lg-12 videoMessage">
                                <div class="mb-3">
                                    <p class="resVideo text-success"></p>
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
                            <div class="col-lg-12 videoMessage2">
                                <div class="mb-3">
                                    <p class="resVideoNotice text-success"></p>
                                    <div id="upload-container">
                                        <button id="browseFileSquare" type="button" class="btn btn-primary formvideo">Загрузить видео заметку (Кружок)</button>
                                    </div>
                                    <p>Не более 20 мб, квадратное, только mp4, кружочек сохраненный из избранного</p>
                                </div>
                                <div class="progress progress-square mt-3" style="height: 25px">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 0%; height: 100%">
                                        0%</div>
                                </div>
                            </div>
                            
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="privat"
                                    id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Защита от копирования
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
    <div class="modal fade" id="createButton">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Создание Кнопки</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body ">
                    <form class="comment-form" method="POST" id="butform"
                        action="{{ route('admin.botconstr.messageButtonCreate') }}">
                        <input type="hidden" name="itemid" value="" id="itemid">
                        <input type="hidden" name="editiid" value="0" id="editiid">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="text-black font-w600 form-label">Текст на кнопке</label>
                                    <input type="text" class="form-control" value="" placeholder=""
                                        name="textbutton">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="text-black font-w600 form-label">Какое сообщение должен прислать</label>
                                    <select class="form-control mb-3" id="optionBut" name="callbackMessage">
                                        <option value="0">Не указанно</option>
                                        @foreach ($messageAll as $mesit)
                                            <option value="{{ $mesit->id_message }}">{{ $mesit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="text-black font-w600 form-label">Указать ссылку на кнопке</label>
                                    <input type="text" class="form-control" value="" placeholder=""
                                        name="callback">
                                    <p class="small">Если указываете ссылку то верхнее поле не трогаем если нужна реф
                                        кнопка указать ref</p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="text-black font-w600 form-label">Ссылка на другого бота</label>
                                    <select class="form-control mb-3" id="optionBut2" name="callbackBot">
                                        <option value="0">Не указанно</option>
                                        @foreach ($bots as $bot)
                                            <option value="{{ $bot->id }}">{{ $bot->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3 mb-0">
                                    <input type="submit" value="Создать" class="submit btn btn-primary cre"
                                        name="submit">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
