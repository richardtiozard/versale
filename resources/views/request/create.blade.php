@extends('layouts.app')

@section('content')

<create-request :categories ='{{ json_encode($categories) }}'></create-request>

@endsection