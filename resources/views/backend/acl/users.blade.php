@extends('backend.layouts.master')

@section('head')
    <title>Dashboard | Users List</title>

    <script>
        var _request = <?= json_encode(Request::all()) ?>;
    </script>
@endsection

@section('body')
@include('backend.includes.header', ['header' => 'Users'])

<section class="dashboard">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Users') }}</li>
            </ol>
        </nav>

        <admin-users-index></admin-users-index>
    </div>
</section>
@endsection