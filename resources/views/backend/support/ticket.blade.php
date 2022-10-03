@extends('backend.layouts.master')

@section('head')
    <title>Dashboard | Support</title>
    <script>
        var _uuid = {!! json_encode($ticket->code) !!};
    </script>
@endsection

@section('body')
@include('backend.includes.header', ['header' => 'Support'])

<section class="dashboard">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="/admin/tickets">{{ __('Support') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">#{{ $ticket->number }}</li>
            </ol>
        </nav>

        <admin-support-ticket></admin-support-ticket>
    </div>
</section>
@endsection