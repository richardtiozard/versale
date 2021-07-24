@extends('layouts.dashboard')

@section('content')

<feedback :data ='{{ json_encode($data) }}'></feedback>

@endsection