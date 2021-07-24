@extends('layouts.app')

@section('content')

<Request :data ='{{ json_encode($data) }}'></Request>

@endsection