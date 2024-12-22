<!DOCTYPE html>
<html lang="ru" class="h-100">
<head>

    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Админка" />
	<meta name="format-detection" content="telephone=no">
	<title>Вход</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link href="{{ asset('/admintheme/css/style.css')}}" rel="stylesheet">
</head>
<body>

  
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                @yield('content')
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('/admintheme/vendor/global/global.min.js')}}"></script>
    <script src="{{ asset('/admintheme/js/custom.js')}}"></script>
	<script src="{{ asset('/admintheme/js/dlabnav-init.js')}}"></script>
    @stack('script')
</body>
</html>