@extends('layouts.dashboard')

@section('content')

<create-product :categories ='{{ json_encode($categories) }}'></create-product>

@endsection
