@extends('layouts.dashboard')

@section('content')

<admin-overview :data ='{{ json_encode($data) }}'></admin-overview>

@endsection
