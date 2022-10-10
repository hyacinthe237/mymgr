@extends('Frontend.layout.master')


@section('head')
    <title>{{ __('app.project') }}s</title>
@endsection


@section('content')
    <div class="content-title">
        <a href="{{ route('project.show', $project->code) }}" class="btn btn-md btn-grey pull-right">
            <i class="ion-reply"></i> @lang('Back to project')
        </a>

        @lang('Edit project')
    </div>

    <div>
        {{ Breadcrumbs::render('editProject', $project) }}
    </div>

    {{--dd($project)--}}
    <project-edit :project="{{ json_encode($project) }}"
        :users="{{ json_encode($users) }}"
        :categories="{{ json_encode($categories) }}"
        :connected="{{ json_encode($connected) }}">
    </project-edit>
@endsection
