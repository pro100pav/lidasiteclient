@extends('template.index')
@section('content')

<div class="container">
    <div class="row h100 justify-content-center align-items-center mt-cu-4">
        <div class="col-lg-6 p-4">
            <div class="text-center">
                <img src="images/logo.svg" class="img-fluid w-50" alt="">
                <p class="h3">Регистрация</p>
                <p class="h4">Ваш наставник: <span id="nastavnik"></span></p>
            </div>
            <form method="POST" action="{{ route('register') }}" class="form" id="formreg">
                @csrf
                <input type="hidden" name="invite" id="invite" value="3">
                <input type="hidden" name="vkref" id="vk" value="">
                <input type="hidden" name="tgref" id="tg" value="">
                <input type="hidden" name="bot" id="bot" value="">
                <div class="row">
                    <div class="col-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="col-6">
                        <div class="mb-3 forminp">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            <label>Как вас зовут? <span>*</span></label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3 forminp">
                            <input type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required>
                                <label>Email <span>*</span></label>
                        </div>
                    </div>
                    <div class="col-6">
                        
                        <div class="mb-3 forminp">
                            <input type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password" value="{{ old('password') }}" required>
                                <label>Пароль <span>*</span></label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3 forminp">
                            <input type="password" class="form-control" name="password_confirmation"
                                required value="{{ old('password_confirmation') }}">
                                <label>Повторите пароль <span>*</span></label>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <button type="submit" class="btn w-100">Зерегистрироваться</button>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><a href="{{ route('password.request') }}" >Восстановить пароль</a></p>
                        <p><a href="{{ route('login') }}">Уже зарегистрированны? Войти!</a></p>
                    </div>
                    <div class="col-md-12">
                        <p class="m-0 text-center">Нажимая "Зерегистрироваться", Вы соглашаетесь с <a href="" target="_blank">регламентом</a> и <a href="">политикой конфиденциальности</a></p>
                        
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush
