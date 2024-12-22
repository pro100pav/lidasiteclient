@extends('template.index')
@section('content')
    <div class="container">
        <div class="row h100 justify-content-center align-items-center mt-cu-4">
            <div class="col-lg-4 blockmain p-4">
                <div class="text-center">
                    <img src="images/logo.svg" class="img-fluid w-50" alt="">
                    <p class="h3">Восстановить пароль</p>
                </div>
                <form method="POST" action="{{ route('password.email') }}" class="form">
                    @csrf
                    <div class="col-12">
                        <div class="mb-3 forminp">
                            <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                        required autocomplete="email" autofocus>
                            <label>Email<span>*</span></label>
                        </div>
                    </div>
                    
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <button type="submit" class="btn btn-login d-block w-100 mt-2">Отправить ссылку на
                        восстановление</button>
                </form>
            </div>
        </div>
    </div>
@endsection
