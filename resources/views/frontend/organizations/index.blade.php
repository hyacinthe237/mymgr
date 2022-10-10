@extends('Frontend.layout.master')


@section('head')
    <title>{{ __('Organisation') }}s</title>
@endsection



@section('content')
    <div class="content-title">
        <a href="/organizations/create" class="btn btn-primary btn-md pull-right">
            <i class="ion-plus"></i> {{ __('Organization') }}
        </a>

        {{ __('app.organization') }}s
    </div>

    <organization :organization="{{ $organization }}"></organization>

@endsection
