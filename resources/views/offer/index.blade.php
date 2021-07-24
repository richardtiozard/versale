@extends('layouts.dashboard')

@section('content')

<Offer :data ='{{ json_encode($data) }}'></Offer>

@endsection
