@extends('backend.layouts.master')

@section('head')
    <title>Dashboard</title>
@endsection

@section('body')
@include('backend.includes.header', ['header' => 'Dashboard'])

<section class="dashboard">
    <div class="container-fluid">
        <div class="cards row">
            <div class="col-sm-3">
                <a href="/admin/bookings">
                    <div class="card blue">
                        <h3>{{ $activeBookings }}</h3>
                        <h5>Active Bookings</h5>
                    </div>
                </a>
            </div>

            <div class="col-sm-3">
                <a href="/admin/acl/users?status=pending">
                    <div class="card wise">
                        <h3>{{ $pendingUsers }}</h3>
                        <h5>Pending Users</h5>
                    </div>
                </a>
            </div>

            <div class="col-sm-3">
                <a href="/admin/tickets?status=pending">
                    <div class="card primary">
                        <h3>{{ $pendingTickets }}</h3>
                        <h5>Pending Tickets</h5>
                    </div>
                </a>
            </div>

            <div class="col-sm-3">
                <a href="/admin/withdrawals?status=Pending">
                    <div class="card success">
                        <h3>{{ $pendingWithdrawals }}</h3>
                        <h5>Pending Withdrawals</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection