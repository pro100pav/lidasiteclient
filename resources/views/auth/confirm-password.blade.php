@extends('template.index')
@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center vh">
            
            <div class="col-lg-4 auth">
                
                <h2 class="card-title text-center py-4">Подтверидите пароль от аккаунта</h2>
               <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="custom-form-floating">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password" placeholder="{{ __('Password') }}">
                                

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-0 mt-2">
                                <button type="submit" class="btn btn-primary text-white">
                                    {{ __('Confirm') }}
                                </button>

                                
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center"><img src="{{ asset('assets/images/logo-white.png') }}" alt="" class="w-50 img-fluid"></div>
            </div>
        </div>
    </div>
@endsection