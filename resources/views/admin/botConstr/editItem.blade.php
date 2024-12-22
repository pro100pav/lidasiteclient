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
                <div class="col-12">
                    <p class="m-0">%name% - Обращение к собеседнику чата по имени</p>
                    <p class="m-0">%userreflink% - Реф ссылка пользователя</p>
                    <p class="m-0">%id% - Id пользователя</p>
                    <p class="m-0">%referuser% - Пригласитель</p>
                    <p class="m-0">%countine% - Колличество в первой линии</p>
                    <p class="m-0">%alluser% - Колиичество пользователей всего в этом боте</p>

                </div>
                <form class="comment-form" method="POST" action="{{route('admin.botconstr.messageItemEditSave', $message->id)}}">
                    @csrf
                    <input type="hidden" name="messageid" value="{{$message->bot_message_id}}">
                    <input type="hidden" name="photomessage" id="photomessage" value="{{$message->images}}">
                    <input type="hidden" name="videomessage" id="videomessage" value="{{$message->video}}">
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
                        <div class="col-lg-12" id="fun">
                            <div class="mb-3">
                                <select class="default-select form-control wide mb-3" name="function" id="selfun">
                                    <option value="0">Без функции</option>
                                    <option value="podpiska" @if ($message->function == 'referals') selected @endif>Список кандидатов</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <div class="form-check custom-checkbox mb-3">
                                    <input type="checkbox" class="form-check-input" name="fixed" id="fixed" @if ($message->fixed == 1) checked @endif>
                                    <label class="form-check-label" for="fixed">Cобщение приклеено к картинке (0 нет, 1 да), при условие что в сообщение менее 1000 символов</label>
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