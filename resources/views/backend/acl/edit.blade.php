@extends('backend.layouts.master')

@section('head')
    <title>Dashboard | Edit User Profile</title>
    <script>
        var _uuid = {!! json_encode($user->code) !!};
    </script>
@endsection

@section('body')
@include('backend.includes.header', [
    'header' => 'Edit @' . $user->username,
])

<section class="dashboard">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="/admin/acl/users">{{ __('Users') }}</a></li>
                <li class="breadcrumb-item">
                    <a href="/admin/acl/users/{{ $user->code }}">{{ '@' . $user->username }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
            </ol>
        </nav>

        <admin-user-edit></admin-user-edit>
    </div>
</section>
@endsection