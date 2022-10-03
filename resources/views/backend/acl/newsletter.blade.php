@extends('backend.layouts.master')

@section('head')
    <title>Dashboard | Newsletter</title>
@endsection

@section('body')
@include('backend.includes.header', ['header' => 'Newsletter'])

<section class="dashboard">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/admin"><i class="feather icon-home"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Newsletter') }}</li>
            </ol>
        </nav>

        <admin-newsletter></admin-newsletter>
    </div>
</section>
@endsection