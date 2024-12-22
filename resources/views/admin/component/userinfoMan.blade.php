<div class="col-xl-4">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-statistics">
                            <div class="text-center">
                                <div class="row">
                                    <div class="col-12">
                                        @if ($userMan->is_username == 0)
                                            <a href="https://t.me/{{ $userMan->username }}" target="_blank">Открыть в телеграме</a>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <span>Юзернейм</span>
                                        <h3 class="m-b-0">{{$userMan->username}}</h3>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="javascript:void(0);" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#sendMessageModal">Отправить сообщение</a>
                                </div> 
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="sendMessageModal">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Отправить сообщение</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="comment-form" method="POST" action="{{route('admin.sendmessage.userTelega', $userMan->id)}}">
                                                @csrf
                                                <div class="row"> 
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="text-black font-w600 form-label">Текст сообщения</label>
                                                            <textarea rows="8" class="form-control" name="comment" placeholder="Текст"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3 mb-0">
                                                            <input type="submit" value="Отправить" class="submit btn btn-primary" name="submit">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>