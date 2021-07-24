@extends('layouts.app')

@section('content')

<Profile :logged-user="{{ json_encode(Auth::user()) }}" :user-profile="{{ json_encode($userprofile) }}"></Profile>

@endsection