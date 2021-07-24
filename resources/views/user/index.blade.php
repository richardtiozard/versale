@extends('layouts.dashboard')

@section('content')

<user :data ='{{ json_encode($data) }}'></user>

@endsection
