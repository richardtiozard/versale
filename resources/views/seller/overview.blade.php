@extends('layouts.dashboard')

@section('content')

<seller-overview :data ='{{ json_encode($data) }}'></seller-overview>

@endsection
