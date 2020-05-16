@extends('layout', ['fullName' => $data['full_name']])

@section('content')
    <p class="text txt-center">
        Właśnie poczyniłeś/aś kroki które wymagają weryfikacji adresu e-mail <br/>
        Poniżej przesyłamy Twój kod weryfikacyjny
    </p>
    <div class="key_verification txt-center">
        {{ $data['key'] }}
    </div>
    <p class="sub-txt txt-center">
        Kod należy wpisać w odpowiednim formularzu na stronie.
    </p>
@endsection
