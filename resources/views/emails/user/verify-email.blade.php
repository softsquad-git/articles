@extends('layout', ['fullName' => $data['full_name']])

@section('content')
    <p class="text txt-center">
        Właśnie udało Ci się zarejestrować konto w serwisie News Up. <br/>
        Poniżej przesyłamy Twój kod weryfikacyjny
    </p>
    <div class="key_verification txt-center">
        {{ $data['key'] }}
    </div>
    <p class="sub-txt txt-center">
        Kod należy wpisać w formularza znajdującym się na stronie aktywacji konta.
    </p>
@endsection
