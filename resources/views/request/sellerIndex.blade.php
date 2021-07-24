@extends('layouts.app')

@section('content')

<seller-request :data ='{{ json_encode($data) }}'></seller-request>

@endsection