<div class="footer bg-blue py-3">
    <div class="container">
        <div class="row justify-content-center align-items-center animate__animated animate__bounceInUp">
            <div class="col-md-12">
                <a href="{{route('index')}}" target="_blanck">Главная</a>
                <a href="{{route('oferta')}}" target="_blanck">Оферта</a>
                <a href="{{route('dashboard.index')}}" target="_blanck">Кабинет</a>
                <a href="{{route('pay-pravila')}}" target="_blanck">Платежи и возвраты</a>
                <p>&copy; 2024-{{\Carbon\Carbon::now()->format('Y')}} {{env('APP_LOGO')}}. Созданно Lidasite.</p>
            </div>
        </div>
    </div>
</div>
