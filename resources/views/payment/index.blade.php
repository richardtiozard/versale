@extends('layouts.app')

@section('content')

<payment :data ='{{ json_encode($data) }}'></payment>

@endsection
