@extends('template.cabinet', [
    'title' => 'Авторизация',
])
@section('content')
    <div class="uk-section uk-section-muted uk-flex uk-flex-middle uk-animation-fade" uk-height-viewport>
        <div class="uk-width-1-1">
            <div class="uk-container">
                <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid>
                    <div class="uk-width-1-1@m">
                        <div
                            class="uk-border-rounded uk-margin uk-width-large uk-margin-auto uk-card uk-card-default uk-card-body">
                            <h3 class="uk-card-title uk-text-center">Вход</h3>
                            <form method="POST" action="{{ route('auth') }}">
                                @csrf
                                <div class="uk-margin">
                                    <label class="uk-form-label" for="form-stacked-text">Код из чат бота</label>
                                    <div class="uk-form-controls">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon uk-form-icon-flip" href="#" uk-icon="icon: user"></span>
                                            <input class="uk-input uk-form-large" type="text" name="code" value="{{ old('code') }}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="uk-margin">
                                    <div class="uk-form-controls">
                                        <label><input type="checkbox" class="uk-checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Запомнить меня</label>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <button class="uk-button uk-button-primary uk-button-large uk-width-1-1">Войти</button>
                                </div>
                                <div class="uk-text-small uk-text-center">
                                    Нет аккаунта? <a href="https://t.me/LidaSite_bot?start=2">Создать или восстановить через бота телеграм</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
