@extends('template.admin', [
    'page' => 'Рассылки',
])
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Рассылки</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th style="width:80px;"><strong>id</strong></th>
                                <th><strong>По какому боту</strong></th>
                                <th><strong>Текст</strong></th>
                                <th><strong>Статус</strong></th>
                                <th><strong>Дата создания</strong></th>
                                <th><strong>Дата запуска</strong></th>
                                <th><strong>Дата завершения</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach ($posts as $post)
                                <tr>
                                    <td><strong>{{$post->id}}</strong></td>
                                    <td>
                                        {{ \Illuminate\Support\Str::limit($post->content, 50, $end='...') }}
                                    </td>
                                    <td>
                                        @if ($post->status == 4)
                                            Рассылка Завершена
                                        @endif
                                        @if ($post->status == 3)
                                            Рассылка выполняется
                                        @endif
                                        @if ($post->status == 2)
                                            Рассылка ждет своей очереди
                                        @endif
                                        @if ($post->status == 1)
                                            Рассылка создается
                                        @endif
                                    </td>
                                    <td  scope="row">{{ Carbon\Carbon::parse($post->created_at)->format('d.m.Y H:i:s') }}</td>
                                    <td  scope="row">{{ Carbon\Carbon::parse($post->sendstart_at)->format('d.m.Y H:i:s') }}</td>
                                    <td  scope="row">{{ Carbon\Carbon::parse($post->updated_at)->format('d.m.Y H:i:s') }}</td>
                                    {{-- <td  scope="row">
                                        <a href="{{route('admin.rassilka.proverka',$post->id)}}" class="btn btn-primary">Отправить себе для проверки</a>
                                        <a href="{{route('admin.rassilka.startRas',$post->id)}}" class="btn btn-primary">Перезапустить</a>
                                    </td> --}}
                                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                    {{ $posts->links('pagination.bootstrap') }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Боты и колличество подписчиков</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th style="width:80px;"><strong>id</strong></th>
                                <th><strong>Название</strong></th>
                                <th><strong>Всего</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach ($bots as $item)
                                <tr>
                                    <td><strong>{{$item->id}}</strong></td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        {{$item->userBot->count()}}
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
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Создание рассылки</h3>
            </div>
            <div class="card-body" style="display: block;">
                <form action="{{route('admin.rassilka.create')}}" method="post">
                    <input type="hidden" name="photomessage" id="photomessage">
                    <input type="hidden" name="videomessage" id="videomessage">
                    @csrf
                    <div class="form-group">
                        <label for="name">Текст рассылки</label>
                        <textarea name="messageras" class="form-control" id="" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Картинка</label>
                        <input class="choose-file form-file-input form-control" type="file" name="photo" id="messageImg">
                        <p class="resp m-0 color-success"></p>
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Ссылка в кнопке</label>
                        <input type="text" class="form-control" name="button" value="">
                    </div>
                    <div class="form-group">
                        <label for="type">В каком боте рассылаем</label>
                        <select id="type" name="bot" class="form-control custom-select">
                            @foreach ($bots as $bot)
                                <option value="{{$bot->id}}">{{$bot->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-success">Создать</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection