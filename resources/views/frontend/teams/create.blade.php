@extends('Frontend.layout.master')


@section('head')
    <title>{{ __('app.team') }}s</title>
@endsection



@section('content')
<div class="content-title">
    <a href="{{ route('teams.index') }}" class="btn btn-md btn-grey pull-right">
        <i class="ion-reply"></i> @lang('Cancel')
    </a>

    {{ __('Add team') }}
</div>


 <team-create></team-create>

@endsection