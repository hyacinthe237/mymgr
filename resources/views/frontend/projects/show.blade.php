@extends('Frontend.layout.master')


@section('head')
    <title>{{ $project->title }} | {{ __('app.project') }}s</title>
@endsection


@section('content')
    <div class="content-title">
        <a href="{{ route('project.edit', $project->code) }}" class="btn btn-primary pull-right">
            <i class="ion-edit"></i> @lang('Edit project')
        </a>

        {{ $project->title }}
    </div>

    <div >
        {{ Breadcrumbs::render('project', $project) }}
    </div>

    <section class="content-body pt-20">
        <div class="_block _block-radius">
            <div class="_block-content">
                @include('projects.nav', ['current' => 'projects'])

                <div class="details">
                    <ul class="list-unstyled metas">
                        <li>
                            <b><i class="ion-alert-circled mr-5"></i> Status:</b> {{ ucfirst($project->status) }}
                        </li>
                        @if ($project->start_date)
                            <li>
                                <b><i class="ion-android-calendar mr-5"></i> Date:</b>
                                {{ date('d/m/Y', strtotime($project->start_date)) }}
                                @if ($project->end_date)
                                    - {{ date('d/m/Y', strtotime($project->end_date)) }}
                                @endif
                            </li>
                        @endif

                        <li>
                            <b><i class="ion-android-person mr-5"></i> Project Owner:</b> {{ ucfirst($project->owner->name) }}
                        </li>

                        @if ($project->files->count())
                            <li>
                                <b><i class="ion-android-attach mr-5"></i> Attachments</b>

                                <ul class="list-inline _files-list">
                                    @foreach ($project->files as $file)
                                        <li>
                                            <a href="{{ $file->link }}" target="_blank">
                                                <i class="ion-paperclip"></i>
                                                {{ $file->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    </ul>


                    @if ($project->description)
                        <div class="item">
                            <h5>@lang('Description')</h5>
                            <div class="text">
                                {!! $project->description !!}
                            </div>
                        </div>
                    @endif

                    @if ($project->goal)
                        <div class="item">
                            <h5>@lang('Objectives')</h5>
                            <div class="text">
                                {!! $project->goal !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <comments :commentable-id={{$project->id}} :commentable-type="{{ json_encode('projects') }}"></comments>
        </div>
    </section>

@endsection
