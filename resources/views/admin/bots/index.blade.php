@extends('template.admin', [
    'page' => 'Чат боты',
])
@section('content')
<div class="row">
    <div class="col-12">
        @if ($globalData['data']['bot_count'] < $bots->count())
            <a href="{{route('admin.bots.create')}}" class="btn btn-success">Создать нового бота</a>
        @endif
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Ваши боты</h4>
                <p>Доступно всего: {{$globalData['data']['bot_count']}}</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bots as $bot)
                                <tr>
                                    <td>
                                        <a href="{{ $bot->link }}" target="_blank" rel="noopener noreferrer">
                                            {{ $bot->name }}
                                        </a>
                                    </td>
                                    <td>{{ $bot->type }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="{{route('admin.bots.edit', $bot->id)}}">Редактировать</a>
                                        @if ($bot->webhook == 0)
                                            <a class="btn btn-success btn-sm" target="_blank" href="https://api.telegram.org/bot{{$bot->token}}/setWebhook?url={{config('app.url')}}/bots/{{$bot->id}}">Установить связь с ботом</a>
                                        @else
                                            Связь установлена
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
@endsection