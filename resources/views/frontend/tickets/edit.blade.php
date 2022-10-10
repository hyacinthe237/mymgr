@extends('Frontend.layout.master')


@section('head')
    <title>Ticket {{ $ticket->number }} {{ $ticket->title }}</title>

    <script>
       var _tickets = <?php echo json_encode($tickets ?? ''); ?>;
       var _projects = <?php echo json_encode($projects ?? ''); ?>;
   </script>
@endsection

@section('content')
    <div class="content-title">
        <a href="{{ route('tickets.show', $ticket->number) }}" class="btn btn-md btn-grey pull-right">
            <i class="ion-reply"></i> @lang('Back to ticket')
        </a>

        <a href="{{ route('tickets.close', $ticket->number) }}" class="btn btn-md btn-success pull-right mr-10">
            <i class="ion-checkmark"></i> {{ $ticket->is_open ? 'Close' : 'Reopen' }} Ticket
        </a>

        @lang('Edit Ticket')
    </div>
    <div >
        {{ Breadcrumbs::render('editTicket', $ticket->project, $ticket) }}
    </div>

    <ticket-edit
        :ticket="{{ json_encode($ticket) }}"
        :members="{{ json_encode($members) }}"
        :statuses="{{ json_encode($statuses)}}"
    >
    </ticket-edit>
@endsection
