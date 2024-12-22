<div class="row">
    <div class="col-lg-12">
        <div class="profile card card-body px-3 pt-3 pb-0">
            <div class="profile-head">
                <div class="profile-info">
                    <div class="profile-photo">
                        <img src="{{$user->name}}" class="img-fluid rounded-circle" alt="">
                    </div>
                    <div class="profile-details">
                        <div class="profile-name px-3 pt-2">
                            <h4 class="text-primary mb-0">{{$user->name}}</h4>
                            <p>Попал в бота: {{ Carbon\Carbon::parse($user->created_at)->format('d.m.Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>