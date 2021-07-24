@extends('layouts.plain')

@section('content')
<Login login-route="{{ route('login') }}" register-route="{{ route('register') }}"></Login>
@endsection
