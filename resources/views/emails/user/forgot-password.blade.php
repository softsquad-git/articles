@extends('layout', ['fullName' => $data['full_name']])
@section('content')
    <p class="text txt-center">
        Właśnie podjąłeś/aś próbę zmiany hasła do swojego konta <br/>
        poniżej znajduje się kod który musisz wpisać w formularzu zminy hasła
    <div class="key_verification txt-center">
        {{ $data['key'] }}
    </div>
    </p>
@endsection
