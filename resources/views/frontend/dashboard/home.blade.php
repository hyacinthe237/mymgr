@extends('Frontend.layout.master')

@section('head')
    <title>@lang('Dashboard')</title>
@endsection


{{-- @section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard') }}
@endsection --}}


@section('content')
    <div class="content-title">
        <div class="row">
            <div class="col-sm-6">
                @lang('Dashboard')
            </div>
        </div>
    </div>


    <section class="dashboard">
            <div class="cards row">
                <div class="col-sm-3">
                    <div class="card blue">
                        <h3>{{ $statistics['project']['all']}}</h3>
                        <h5>Projects</h5>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card purple">
                        <h3>{{ $statistics['member']['all']}}</h3>
                        <h5>Members</h5>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card red">
                        <h3>{{ $statistics['ticket']['open']}}</h3>
                        <h5>Open Tickets</h5>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card dark">
                        <h3>{{ $statistics['ticket']['close']}}</h3>
                        <h5>Resolved Tickets</h5>
                    </div>
                </div>
            </div>
    </section>



    <dashbord :statistics="{{ json_encode($statistics) }}" ></dashbord>
@endsection
