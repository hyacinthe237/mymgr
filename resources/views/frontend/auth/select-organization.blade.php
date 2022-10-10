@extends('frontend.layout.auth')

@section('head')
    <title>Organization</title>
@endsection


@section('content')
    <section class="login-page">
        <div class="login-container">
            <div class="inner">
                <div class="">
                    <h4 class="bold">Organization</h4>

                    @if ($user->organizations()->count())
                        <auth-organization-select
                            :organizations="{{ json_encode($user->organizations) }}" />
                    @else
                        <auth-organization-create></auth-organization-create>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
