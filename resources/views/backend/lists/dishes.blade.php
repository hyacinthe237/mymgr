@extends('backend.layouts.master')

@section('head')
    <title>Dashboard | Dishes</title>
@endsection

@section('body')
@include('backend.includes.header', ['header' => 'Dishes'])

<section class="dashboard">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Dishes') }}</li>
            </ol>
        </nav>

        <admin-dishes />
    </div>
</section>
@endsection