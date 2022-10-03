@extends('backend.layouts.master')

@section('head')
    <title>Dashboard | Roles</title>
@endsection

@section('body')
@include('backend.includes.header', ['header' => 'Roles'])

<section class="dashboard">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Roles') }}</li>
            </ol>
        </nav>

        <admin-roles-documents />
    </div>
</section>
@endsection