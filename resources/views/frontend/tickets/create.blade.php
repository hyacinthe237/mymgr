@extends('Frontend.layout.master')


@section('head')
    <title>{{ __('app.ticket') }}s</title>
@endsection


@section('content')
<div class="content-title">
    <a href="{{ route('project.tickets', $project->code) }}" class="btn btn-md btn-grey pull-right">
        <i class="ion-reply"></i> @lang('Cancel')
    </a>

    {{ __('Add ticket') }}
    <br>

</div>
<div >
    {{ Breadcrumbs::render('addTicket', $project) }}
</div>

<ticket-create
    :project-id={{ $project->id }}
    :project="{{ json_encode($project) }}"
    :statuses="{{ json_encode($statuses) }}"
    :members="{{ json_encode($members) }}">
</ticket-create>
@endsection
