@extends('backend.layouts.master')

@section('head')
    <title>Dashboard | Cuisines</title>
@endsection

@section('body')
@include('backend.includes.header', ['header' => 'Cuisines'])

<section class="dashboard">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="/admin/lists/cuisines">{{ __('Cuisines') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">New Cuisine</li>
            </ol>
        </nav>

        <admin-cuisine-create />
    </div>
</section>
@endsection