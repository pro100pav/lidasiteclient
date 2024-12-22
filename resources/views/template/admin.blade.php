<!DOCTYPE html>
<html lang="ru">
<head>

    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Админка" />
	<meta name="format-detection" content="telephone=no">
	<title>Админка</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="icon" type="image/x-icon" href="/favicon.ico">
	<link href="{{ asset('/admintheme/vendor/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('/admintheme/vendor/nouislider/nouislider.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/libs/summer/summernote.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/libs/summer/summernote-lite.css')}}">
    <link href="{{ asset('/admintheme/css/style.css')}}" rel="stylesheet">
</head>
<body>

  
    <div id="main-wrapper">

        <div class="nav-header">
            <a href="{{route('admin.index')}}" style="color:#111;" class="brand-logo">
				LIDACRM
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
		

        @include('admin.component.navigation', [
            'page' => $page,
        ])
        @include('admin.component.sidebar')

        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
                @yield('content')
				
            </div>
        </div>

        <div class="footer">
		
            <div class="copyright">
                
            </div>
        </div>

		@include('admin.component.alerts')


	</div>

    <!-- Required vendors -->
    <script src="{{ asset('/admintheme/vendor/global/global.min.js')}}"></script>
	<script src="{{ asset('/admintheme/vendor/chart.js/Chart.bundle.min.js')}}"></script>
	<script src="{{ asset('/admintheme/vendor/jquery-nice-select/js/jquery.nice-select.min.js')}}"></script>
	
	<!-- Apex Chart -->
    <script src="{{ asset('/admintheme/vendor/chart.js/Chart.bundle.min.js')}}"></script>
    <script src="{{ asset('/admintheme/js/plugins-init/chartjs-init.js')}}"></script>
	<script src="{{asset('/assets/libs/summer/summernote.min.js')}}"></script>
    <script src="{{asset('/assets/libs/summer/summernote-lite.js')}}"></script>
    <script src="{{asset('/assets/libs/summer/lang/summernote-ru-RU.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/resumable.js/1.1.0/resumable.min.js"></script>
    <script src="{{ asset('/admintheme/js/custom.js')}}"></script>
	<script src="{{ asset('/admintheme/js/dlabnav-init.js')}}"></script>
    @stack('script')
</body>
</html>