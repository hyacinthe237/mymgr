@extends('Frontend.layout.master')


@section('head')
    <title>{{ __('app.organization') }}s</title>
@endsection



@section('content')
    <div class="content-title">
        <a href="{{ route('organizations.index') }}" class="btn btn-md btn-grey pull-right">
            <i class="ion-reply"></i> @lang('Cancel')
        </a>

        {{ __('Add organization') }}
    </div>




    <organization-create :admin-id={{ Auth::user()->id }}></organization-create>



@endsection
