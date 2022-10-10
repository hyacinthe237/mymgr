@extends('Frontend.layout.master')


@section('head')
    <title>{{ __('Members') }}</title>
@endsection



@section('breadcrumbs')
    {{ Breadcrumbs::render('member', $member) }}
@endsection



@section('content')
    <Member
        :member="{{ json_encode($member) }}"
        :userconnect="{{ json_encode($userconnect) }}"
        :organization="{{ json_encode($organization) }}"
        :is-profile="true">
    </Member>
@endsection
