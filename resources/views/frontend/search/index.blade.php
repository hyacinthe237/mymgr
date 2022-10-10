@extends('Frontend.layout.master')

@section('head')
    <title>{{ __('Search') }}s</title>
@endsection

@section('content')
    <div class="content-title">
        {{ __('Your Results') }}
    </div>

    <search :result="{{ json_encode($result) }}"></search>

@endsection
