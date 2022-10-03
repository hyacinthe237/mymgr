@extends('backend.layouts.master')

@section('head')
    <title>Dashboard | Support</title>
    <script>
        var _request = <?= json_encode(Request::all()) ?>;
    </script>
@endsection

@section('body')
@include('backend.includes.header', ['header' => 'Support'])

<section class="dashboard">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Support') }}</li>
            </ol>
        </nav>

        <admin-support-tickets></admin-support-tickets>
    </div>
</section>
@endsection