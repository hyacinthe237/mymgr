@extends('backend.layouts.master')

@section('head')
    <title>Dashboard | User Profile</title>
    <script>
        var _uuid = {!! json_encode($user->code) !!};
    </script>
@endsection

@section('body')
@include('backend.includes.header', [
    'header' => '@' . $user->username,
])

<section class="dashboard">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="/admin/acl/users">{{ __('Users') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ '@' . $user->username }}</li>
            </ol>
        </nav>

        @if (Request::is('admin/acl/users/' . $user->code))
            <admin-user-profile></admin-user-profile>
        @elseif (Request::is('admin/acl/users/' . $user->code . '/edit'))
            <admin-user-edit></admin-user-edit>
        @elseif (Request::is('admin/acl/users/' . $user->code . '/bookings'))
            <admin-user-bookings></admin-user-bookings>
        @elseif (Request::is('admin/acl/users/' . $user->code . '/payments'))
            <admin-user-payments></admin-user-payments>
        @elseif (Request::is('admin/acl/users/' . $user->code . '/documents'))
            <admin-user-documents></admin-user-documents>
        @endif
    </div>
</section>
@endsection