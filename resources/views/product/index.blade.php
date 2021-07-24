@extends('layouts.dashboard')

@section('content')

<Product :data ='{{ json_encode($data) }}'></Product>

@endsection
