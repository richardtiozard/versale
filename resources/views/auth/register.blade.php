@extends('layouts.plain')

@section('content')
<Register login-route="{{ route('login') }}" register-route="{{ route('register') }}"></Register>

@endsection
