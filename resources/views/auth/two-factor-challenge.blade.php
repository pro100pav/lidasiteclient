@extends('template.index')
@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center vh">
            <div class="col-lg-6 auth">
                <h2 class="card-title text-center py-4">Подтверждение входа</h2>
               <div class="card">
                    <div class="card-body">
                    <form method="POST" action="{{ route('two-factor.login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="code" class="col-md-4 col-form-label text-md-right">Код авторизации из приложение</label>

                            <div class="col-md-6">
                                <input id="code" type="code" class="form-control @error('code') is-invalid @enderror" name="code" required autocomplete="current-code">

                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-0 form-group row">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Отправить') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <p class="h4">Или</p>
            <div class="mt-3 card">
                <div class="card-header">Код восстановения полученый при включение двух факторной авторизации</div>

                <div class="card-body">
                    

                    <form method="POST" action="{{ route('two-factor.login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="recovery_code" class="col-md-4 col-form-label text-md-right">Код восстановления</label>

                            <div class="col-md-6">
                                <input id="recovery_code" type="recovery_code" class="form-control @error('recovery_code') is-invalid @enderror" name="recovery_code" required autocomplete="current-recovery_code">

                                @error('recovery_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-0 form-group row">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Отправить') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center"><img src="{{ asset('assets/images/logo-white.png') }}" alt="" class="w-50 img-fluid"></div>
        </div>
    </div>
</div>
@endsection