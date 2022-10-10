@extends('Frontend.layout.master')


@section('head')
    <title>{{ $project->title }} | {{ __('app.ticket') }}s</title>
@endsection


@section('content')
    <div class="content-title">
        {{ $project->title }}
    </div>

    <div >
        {{ Breadcrumbs::render('projectStats', $project) }}
    </div>

    <section class="content-body pt-20">
        <div class="_block _block-radius">
            <div class="_block-content">
                @include('projects.nav', ['current' => 'stats'])

                <div class="mt-20">
                    <div class="block-item">
                        <project-stats :stats="{{ json_encode($stats) }}"></project-tickets>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
