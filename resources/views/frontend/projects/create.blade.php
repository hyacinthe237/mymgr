@extends('Frontend.layout.master')


@section('head')
    <title>{{ __('app.project') }}s</title>
@endsection



@section('content')
    <div class="content-title">
        <a href="{{ route('projects.index') }}" class="btn btn-md btn-grey pull-right">
            <i class="ion-reply"></i> @lang('Cancel')
        </a>

        {{ __('Add project') }}
    </div>


    <section class="content-body pt-20">
        <div class="_block _block-radius">
            <div class="_block-content">
                {!! Form::open(['url' => route('projects.index'), 'method' => 'post', 'class' => '_form']) !!}

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('title', __('Title')) !!}
                            {!! Form::text('title', null, [
                                    'placeholder' => 'Project title',
                                    'class' => 'form-control input-lg',
                                    'autocomplete' => 'off',
                                    'required' => true
                                ])
                            !!}
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            {!! Form::label('visibility', __('Visibility')) !!}
                            {!! Form::select('is_public', [0 => __('Private'), 1 => __('Public')], null, ['class' => 'form-control input-lg'] ) !!}
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            {!! Form::label('status', __('Status')) !!}
                            {!! Form::select('status',
                                [
                                    'pending'  => __('Pending'),
                                    'ongoing'  => __('Ongoing'),
                                    'complete' => __('Complete')
                                ], null,
                                ['class' => 'form-control input-lg'] ) !!}
                        </div>
                    </div>
                </div>
                {{-- End of title  --}}


                <div class="row mt-10">
                    <div class="col-sm-3">
                        <div class="form-group">
                            {!! Form::label('start_date', __('Start Date')) !!}
                            {!! Form::date('start_date', null, ['placeholder' => 'Start date', 'class' => 'form-control input-lg']) !!}
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            {!! Form::label('end_date', __('Due Date')) !!}
                            {!! Form::date('end_date', null, ['placeholder' => 'Due date', 'class' => 'form-control input-lg']) !!}
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            {!! Form::label('category', __('Category')) !!}
                            {!! Form::select('category_id',
                                [
                                    '1'  => "Projet Interne",
                                    '2'  => "Project Externe"
                                ], null,
                                ['class' => 'form-control input-lg'] ) !!}
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            {!! Form::label('owner', __('Project owner')) !!}
                            {!! Form::select('owner_id',
                                [
                                    '1'  => "John Doe",
                                    '2'  => "Jane Doe"
                                ], null,
                                ['class' => 'form-control input-lg'] ) !!}
                        </div>
                    </div>
                </div>
                {{-- End of selects  --}}


                {{-- End of dates  --}}

                <div class="row mt-10">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {!! Form::label('description', 'Description') !!}
                            {!! Form::textarea('description', null, ['placeholder' => 'Project description', 'class' => 'form-control', 'rows' => 5]) !!}
                        </div>
                    </div>

                    <div class="col-sm-12 mt-10">
                        <div class="form-group">
                            {!! Form::label('goals', __('Objectives')) !!}
                            {!! Form::textarea('goals', null, ['placeholder' => 'Project objectives', 'class' => 'form-control', 'rows' => 3]) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group text-right mt-20">
                    <button type="submit" class="btn btn-md btn-primary">
                        <i class="ion-checkmark"></i> @lang('Save Project')
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>

@endsection
