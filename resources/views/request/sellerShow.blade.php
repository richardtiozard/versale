@extends('layouts.app')

@section('content')

<seller-show :data ='{{ json_encode($data) }}'></seller-show>

@endsection