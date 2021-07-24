@extends('layouts.app')

@section('content')

<show-offer :data ='{{ json_encode($data) }}'></show-offer>

@endsection