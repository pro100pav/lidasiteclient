@extends('template.index')
@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center vh">
            <div class="col-md-8">
                <div class="blockmain p-2 mt-3">
                    <div class="text-center mt-2">
                        <p class="h3">Подтверждение email адреса {{ Auth::user()->email }}</p>
                        <p>Прежде чем продолжить, пожалуйста, проверьте письмо подтверждения в своей электронной почте</p>
                        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <p>Если Вы не получили письмо,
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>
                            </p>
                        </form>
                        <form method="POST" action="{{ route('auth.verify.email') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-md-4">
                                    <input type="text" name="verified_code" maxlength="4"
                                        class="form-control text-center" value="" placeholder="Введите код из письма">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-login mt-3">
                                Отправить код
                            </button>
                        </form>
                        <p>Если письмо не приходит, проверьте правильность введеной почты, что бы поменять email <button
                                type="button" class="btn btn-link p-0 m-0 align-baseline" id="replacebalance">нажмите
                                сюда</button></p>
                        @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="replacebalance d-none mt-3">
                            <form method="POST" action="{{ route('auth.changeemail') }}">
                                @csrf

                                <div class="row justify-content-center align-items-center">
                                    <div class="col-md-4">
                                        <input type="text" name="email" class="form-control text-center" value=""
                                            placeholder="Введите новый email">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-login mt-3">
                                    Изменить
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="text-end mt-2">
                        <form class="d-inline" method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
