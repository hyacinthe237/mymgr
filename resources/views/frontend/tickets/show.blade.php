@extends('Frontend.layout.master')


@section('head')
    <title>{{ $ticket->title }} | {{ __('app.ticket') }}s</title>
@endsection


@section('content')
    <div class="row content-title">
        <div class="col-sm-12 col-lg-12">
            <a href="{{ route('tickets.edit', $ticket->number) }}" class="btn btn-md btn-primary pull-right">
                <i class="ion-edit"></i> @lang('Edit Ticket')
            </a>

            #{{ $ticket->number }} {{ $ticket->title }}
        </div>
    </div>

    <div >
        {{ Breadcrumbs::render('ticket', $ticket->project, $ticket) }}
    </div>


    <section class="content-body pt-20">
        <div class="_block _block-radius">
            <div class="_block-content">
                <div class="">
                    <ul class="list-unstyled metas">
                        <li>
                            <b><i class="ion-alert-circled mr-10"></i> Status:</b> {{ ucfirst($ticket->category->name) }}
                        </li>

                        <li>
                            <b><i class="ion-android-arrow-up mr-10"></i> Priority:</b> {{ ucfirst($ticket->priority) }}
                        </li>

                        <li>
                            <b><i class="ion-briefcase mr-10"></i> Project:</b>
                            <a href="{{ route('project.tickets', $ticket->project->code) }}">
                                {{ $ticket->project->title }}
                            </a>
                        </li>

                        @if ($ticket->start_date)
                            <li>
                                <b><i class="ion-android-calendar mr-10"></i> Date:</b>
                                {{ date('d/m/Y', strtotime($ticket->start_date)) }}
                                @if ($ticket->end_date)
                                    - {{ date('d/m/Y', strtotime($ticket->end_date)) }}
                                @endif
                            </li>
                        @endif

                         @if ($ticket->assignee)
                        <li>
                            <b><i class="ion-android-person mr-10"></i> Assigned to:</b> {{ ucfirst($ticket->assignee->name) }}
                        </li>
                         @endif

                         @if ($ticket->files->count())
                             <li>
                                 <b><i class="ion-android-attach mr-10"></i> Attachments</b>

                                 <ul class="list-inline _files-list">
                                     @foreach ($ticket->files as $file)
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

                    @if ($ticket->parent_id)
                        <ul class="list-unstyled">
                            <li><b><i class="ion-soup-can mr-10"></i> Parent Ticket</b>
                                 <a href="{{ $ticket->parent->number }}" data-toggle="dropdown" class="dropdown-toggle text">
                                    #{{ $ticket->parent->number }} {{ $ticket->parent->title }}
                                </a>
                            </li>
                        </ul>
                    @endif

                    @if ($ticket->children->count())
                        <p><b><i class="ion-filing mr-10"></i> Sub Tickets</b>
                            <ul class="list-unstyled">
                                @foreach ($ticket->children as $key)
                                    <li> <a href="{{ $key->number }}">
                                        #{{ $key->number }} {{ $key->title }}</a></li>
                                @endforeach
                            </ul>
                        </p>
                    @endif

                    @if ($ticket->description)
                        <div class="item">
                            <h5><b>@lang('Description')</b></h5>
                            <div class="text">
                                {!! $ticket->description !!}
                            </div>
                        </div>
                    @endif


                </div>

            </div>


            <comments :commentable-id={{ $ticket->id }} :commentable-type="{{ json_encode('tickets') }}"></comments>

            <ticket-activity :number="{{ $ticket->number }}"></ticket-activity>
        </div>
    </section>

@endsection
