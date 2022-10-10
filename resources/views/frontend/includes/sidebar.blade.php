<div class="sidebar">
    <ul class="list-unstyled">
        <li>
            <a href="/dashboard" class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <i class="ion-speedometer"></i> {{ __('Dashboard') }}
            </a>
        </li>

        <li>
            <a href="/projects" class="{{ Request::is('projects*') ? 'active' : '' }}">
                <i class="ion-briefcase"></i> @lang('Projects')
            </a>
        </li>

        <li>
            <a href="/tickets" class="{{ Request::is('tickets*') ? 'active' : '' }}">
                <i class="ion-social-buffer"></i> @lang('Tickets')
            </a>
        </li>

        <li>
            <a href="/mytickets" class="{{ Request::path() == 'mytickets' ? 'active' : '' }}">
                <i class="ion-folder"></i> @lang('My Page')
            </a>
        </li>

        <li>
            <a href="/profile" class="{{ Request::is('profile*') ? 'active' : '' }}">
                <i class="ion-android-person"></i> @lang('Profile')
            </a>
        </li>

        <li>
            <a href="/logout">
                <i class="ion-power"></i> @lang('Signout')
            </a>
        </li>

    </ul>
</div>
