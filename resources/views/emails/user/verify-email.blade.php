@extends('layout', ['fullName' => $data['full_name']])

@section('content')
    <p class="text txt-center">
        Właśnie poczyniłeś/aś kroki które wymagają weryfikacji adresu e-mail <br/>
        Poniżej przesyłamy Twój kod weryfikacyjny
    </p>
    <div class="key_verification txt-center">
        <a href="{{ config('app.url') }}/aktywuj-konto/{{ $data['key'] }}" title="Aktywuj konto"
        style="">
            Aktywuj konto
        </a>
    </div>
    <p class="sub-txt txt-center">
        Kliknij w powyższy przycisk a następnie "Zapisz".  <br/>
        Jeśli link nie działa lub występują inne problemy możesz również <br/>
        skopiować poniższy kod na wyświetlonej stronie <br/>
        <b>{{ $data['key'] }}</b>
    </p>
@endsection
