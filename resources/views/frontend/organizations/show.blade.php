@extends('Frontend.layout.master')


@section('head')
    <title>{{ $organization->name }}</title>
@endsection



@section('content')
    <div class="content-title">
        {{ $organization->name }}
    </div>

    <organization-create :admin-id="{{ Auth::user()->id }}" :organization="{{ $organization }}" :user="{{ $user }}"></organization-create>

@endsection
