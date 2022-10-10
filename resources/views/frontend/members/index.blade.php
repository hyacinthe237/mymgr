@extends('Frontend.layout.master')


@section('head')
    <title>{{ __('Members') }}s</title>
@endsection



@section('breadcrumbs')
    {{ Breadcrumbs::render('members') }}
@endsection



@section('content')
    <Members></Members>
@endsection
