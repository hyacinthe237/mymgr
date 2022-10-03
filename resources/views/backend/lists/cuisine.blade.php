@extends('backend.layouts.master')

@section('head')
    <title>Dashboard | Cuisines</title>
    <script>
        var _uuid = {!! json_encode($cuisine->code) !!};
    </script>
@endsection

@section('body')
@include('backend.includes.header', ['header' => 'Cuisines'])

<section class="dashboard">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="/admin/lists/cuisines">{{ __('Cuisines') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $cuisine->name }}</li>
            </ol>
        </nav>

        <admin-cuisine />
    </div>
</section>
@endsection