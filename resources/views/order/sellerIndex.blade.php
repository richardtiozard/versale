@extends('layouts.dashboard')

@section('content')

<seller-order :data ='{{ json_encode($data) }}'></seller-order>

@endsection