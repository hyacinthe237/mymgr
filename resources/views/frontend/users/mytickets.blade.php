@extends('Frontend.layout.master')

@section('head')
    <title>{{ __('My Page') }}s</title>
@endsection

@section('content')
    <div class="content-title">
        {{ __('My Page') }}
    </div>

    <mytickets :tickets="{{ json_encode($tickets) }}"></mytickets>

@endsection
