@extends('Frontend.layout.master')

@section('head')
    <title>{{ __('Profile') }}s</title>
@endsection

@section('content')
    <div class="content-title">
        <a href="{{ route('teams.index') }}" class="btn btn-md btn-grey pull-right">
            <i class="ion-reply"></i> @lang('Cancel')
        </a>

        {{ __('Edit Profile') }}
    </div>


    <profile :user="{{ json_encode($user) }}"></profile>
@endsection
