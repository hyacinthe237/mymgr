@extends('Frontend.layout.master')


@section('head')
    <title>{{ __('app.ticket') }}s</title>
@endsection


@section('content')
    <tickets :users="{{ json_encode($users) }}" :categories="{{ json_encode($ticketCategories) }}" :projects="{{ json_encode($projects) }}"></tickets>
@endsection
