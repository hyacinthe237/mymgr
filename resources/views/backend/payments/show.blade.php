@extends('backend.layouts.master')

@section('head')
    <title>Dashboard | Payment</title>
    <script>
        var _uuid = {!! json_encode($model->code) !!};
    </script>
@endsection

@section('body')
@include('backend.includes.header', ['header' => 'Payment'])

<section class="dashboard">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="/admin/tickets">{{ __('Payment') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">#{{ $model->number }}</li>
            </ol>
        </nav>

        
    </div>
</section>
@endsection