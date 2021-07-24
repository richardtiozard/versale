@extends('layouts.app')

@section('content')

<order :data ='{{ json_encode($data) }}'></order>

@endsection
