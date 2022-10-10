@extends('layouts.master')

@section('head')
    <title>@lang('Notifications')</title>
@endsection



@section('content')
    <notifications notifications="{{ json_encode($notifications) }}"></notifications>
@endsection
