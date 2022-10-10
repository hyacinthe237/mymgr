<ul class="nav nav-tabs">
    <li class="{{ $current === 'projects' ? 'active' : '' }}">
        <a href="{{ route('project.show', $project->code) }}">
            <i class="ion-clipboard"></i> @lang('Project')
        </a>
    </li>
    <li class="{{ $current === 'tickets' ? 'active' : '' }}">
        <a href="{{ route('project.tickets', $project->code) }}">
            <i class="ion-social-buffer"></i> @lang('Tickets')
        </a>
    </li>
    <li class="{{ $current === 'stats' ? 'active' : '' }}">
        <a href="{{ route('project.stats', $project->code) }}">
            <i class="ion-stats-bars"></i> Stats
        </a>
    </li>
</ul>
