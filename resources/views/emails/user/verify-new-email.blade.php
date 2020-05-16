@extends('layout', ['fullName' => \Illuminate\Support\Facades\Auth::user()->specificData->name . ' ' . \Illuminate\Support\Facades\Auth::user()->specificData->last_name])
@section('content')
<p class="txt-center text">
    Właśnie otrzymaliśmy informację o podjęciu przez Ciebie próby zmiany adresu e-mail. <br/>
    Jeśli faktycznie wykonałeś/aś takie kroki poniżej przesyłamy kod weryfikacyjny.
</p>
    <div class="key_verification txt-center">
    {{$data->_key}}
</div>
<p class="txt-center text">
    Jeśli to nie Ty zmień hasło do swojego konta i poinformuj nas o zainstniałej <br/>
    sytuacji korzystając z formularza kontaktowego
</p>
@endsection
