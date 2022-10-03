@extends('backend.layouts.master')

@section('head')
    <title>Dashboard | Booking</title>
    <script>
        var _uuid = {!! json_encode($booking->code) !!};
    </script>
@endsection

@section('body')
@include('backend.includes.header', ['header' => 'Bookings'])

<section class="dashboard">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="/admin/bookings">{{ __('Bookings') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">#{{ $booking->number }}</li>
            </ol>
        </nav>

        <admin-booking />
    </div>
</section>
@endsection