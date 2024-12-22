@extends('template.admin', [
    'page' => 'Группы к которым подключен наш бот',
])
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Группы</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Название</th>
                                <th>Тригер</th>
                                <th>Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groups as $group)
                                    <tr>
                                        <td>
                                            {{ $group->group_id }}
                                        </td>
                                        <td>
                                            {{ $group->group_name }}
                                        </td>
                                        <td>
                                            @if ($group->podpiska == 1)
                                                Принимает рекламные посты из бота
                                            @else
                                                Не принимает рекламные посты из бота
                                            @endif
                                        </td>
                                        <td>
                                            @if ($group->podpiska == 1)
                                            <a class="btn btn-danger btn-sm" href="{{route('admin.groups.groupPodpis', $group->id)}}">Отключить рекламные посты из бота</a>
                                            @else
                                            <a class="btn btn-info btn-sm" href="{{route('admin.groups.groupPodpis', $group->id)}}">Включить рекламные посты из бота</a>
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