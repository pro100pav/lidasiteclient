@if (Session::has('message'))
    <script>UIkit.notification({message: '{!! Session::get('message') !!}', status: 'primary'})</script>
@endif
@if (Session::has('danger'))
    <script>UIkit.notification({message: '{!! Session::get('danger') !!}', status: 'danger'})</script>
@endif
@if (Session::has('success'))
    <script>UIkit.notification({message: '{!! Session::get('success') !!}', status: 'success'})</script>
@endif
