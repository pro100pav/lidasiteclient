@extends('template.admin', [
    'page' => 'Пользователь ' . $user->name,
])
@section('content')
    @include('admin.component.userHead')
    <div class="row">
        @include('admin.component.userinfo')
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            @include('admin.component.usernav')
                            <div class="profile-personal-info">
                                
                                    <div class="card chat dlab-chat-history-box">
                                        <div class="card-header chat-list-header text-center">
                                            <div>
                                                <h6 class="mb-1">Чат с {{$user->name}}</h6>
                                            </div>
                                        </div>
                                        <div class="card-body msg_card_body chatContainer" id="dlab_W_Contacts_Body3">
                                            @foreach ($chat->messages as $message)
                                                @if ($message->message_user)
                                                    <div class="d-flex justify-content-end mb-4">
                                                        <div class="msg_cotainer_send">
                                                            <p><strong>{{$user->name}}</strong></p>
                                                            {{$message->message_user}}
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="d-flex justify-content-start mb-4">
                                                        <div class="msg_cotainer">
                                                            <p><strong>Бот</strong></p>
                                                            {{$message->message_bot}}
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        {{-- <div class="type_msg">
                                            <form action="{{route('admin.user.chatSend',['id' => $user->id,'chat'=> $chat->id])}}" method="post">
                                                @csrf
                                                <div class="input-group">
                                                    <textarea class="form-control" name="message" placeholder="Ваше сообщение"></textarea>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary"><i class="fa fa-location-arrow"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div> --}}
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


