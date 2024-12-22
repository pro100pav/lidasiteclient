@extends('template.index')
@section('content')
<div class="container">
    <div class="row vh justify-content-center align-items-center mt-cu-4">
        <div class="col-lg-4 blockmain p-4">
            <div class="text-center">
                <img src="images/logo.svg" class="img-fluid w-50" alt="">
                <p class="h3">Придумайте новый пароль</p>
            </div>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token"
                        value="{{ $request->route('token') }}">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            <input placeholder="{{ __('E-Mail Address') }}" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $request->email) }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="mb-3">

                            <input placeholder="Придумайте новый пароль" id="password"
                            type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <input placeholder="Повторите новый пароль"
                            id="password-confirm" type="password" class="form-control"
                            name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group mt-2 mb-0">
                        <button type="submit" class="btn btn-login d-block">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection