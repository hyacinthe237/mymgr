@extends('Frontend.layout.master')


@section('head')
    <title>{{ $project->title }} | {{ __('app.ticket') }}s</title>
@endsection


@section('content')
    <div class="content-title">
        <a href="{{ route('project.tickets.create', $project->code) }}" class="btn btn-primary pull-right">
            <i class="ion-plus"></i> @lang('Add ticket')
        </a>

        {{ $project->title }}
    </div>

    <div>
        {{ Breadcrumbs::render('projectTickets', $project) }}
    </div>

    <section class="content-body pt-20">
        <div class="_block _block-radius">
            <div class="_block-content">
                @include('projects.nav', ['current' => 'tickets'])

                <div class="_tickets-list mt-20">
                    <div class="block-item">
                        <project-tickets :project="{{ json_encode($project) }}"
                        :users="{{ json_encode($users) }}"></project-tickets>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
