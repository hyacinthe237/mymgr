<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="brand">
            <div class="mobile-menu sidebar">
                <i class="feather icon-x" onclick="toggleSidebar()"></i>
            </div>

            <a href="{{ route('admin.dashboard') }}">
                {{ config('app.name') }}
            </a>
        </li>

        <li class="{{ Request::is('admin') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <i class="feather icon-home"></i>
                {{ __('Dashboard') }}
            </a>
        </li>

        <li class="{{ Request::is('admin/bookings*') ? 'active' : '' }}">
            <a href="{{ route('admin.bookings') }}">
                <i class="feather icon-calendar"></i>
                {{ __('Bookings') }}
            </a>
        </li>

        <li class="{{ Request::is('admin/payments*') ? 'active' : '' }}">
            <a href="{{ route('admin.payments') }}">
                <i class="feather icon-shopping-cart"></i>
                {{ __('Payments') }}
            </a>
        </li>

        <li class="{{ Request::is('admin/withdrawals*') ? 'active' : '' }}">
            <a href="{{ route('admin.withdrawals') }}">
                <i class="feather icon-repeat"></i>
                {{ __('Withdrawals') }}
            </a>
        </li>

        <li class="dropdown {{ Request::is('admin/acl*') ? 'active' : '' }}">
            <a href="#submenu1" data-toggle="collapse" data-target="#submenu1">
                <i class="feather icon-users"></i>
                {{ __('Access Control') }}
                <i class="feather icon-chevron-down float-right"></i>
            </a>
            <div 
                class="collapse {{ Request::is('admin/acl*') ? 'show' : '' }}" 
                id="submenu1" aria-expanded="false"
            >
                <ul class="sidebar-dropdown">
                    <li class="{{ Request::is('admin/acl/users*') ? 'active' : '' }}">
                        <a href="{{ route('admin.users') }}">
                            <i class="feather icon-chevron-right"></i>
                            {{ __('Users') }}
                        </a>
                    </li>

                    <li class="{{ Request::is('admin/acl/roles*') ? 'active' : '' }}">
                        <a href="{{ route('admin.roles') }}">
                            <i class="feather icon-chevron-right"></i>
                            {{ __('Roles') }}
                        </a>
                    </li>

                    <li class="{{ Request::is('admin/acl/newsletter*') ? 'active' : '' }}">
                        <a href="{{ route('admin.newsletter') }}">
                            <i class="feather icon-chevron-right"></i>
                            {{ __('Newsletter') }}
                        </a>
                    </li>
                </ul>
            </div>
        </li>


        <li class="dropdown {{ Request::is('admin/lists*') ? 'active' : '' }}">
            <a href="#submenu2" data-toggle="collapse" data-target="#submenu2">
                <i class="feather icon-grid"></i>
                {{ __('Lists') }}
                <i class="feather icon-chevron-down float-right"></i>
            </a>
            <div 
                class="collapse {{ Request::is('admin/lists*') ? 'show' : '' }}" 
                id="submenu2" aria-expanded="false"
            >
                <ul class="sidebar-dropdown">
                    <li class="{{ Request::is('admin/lists/cuisines*') ? 'active' : '' }}">
                        <a href="{{ route('admin.cuisines') }}">
                            <i class="feather icon-chevron-right"></i>
                            {{ __('Cuisines') }}
                        </a>
                    </li>

                    <li class="{{ Request::is('admin/lists/dishes*') ? 'active' : '' }}">
                        <a href="{{ route('admin.dishes') }}">
                            <i class="feather icon-chevron-right"></i>
                            {{ __('Dishes') }}
                        </a>
                    </li>
                </ul>
            </div>
        </li>


        <li class="{{ Request::is('admin/documents*') ? 'active' : '' }}">
            <a href="{{ route('admin.documents') }}">
                <i class="feather icon-folder"></i>
                {{ __('Documents') }}
            </a>
        </li>

        <li class="{{ Request::is('admin/tickets*') ? 'active' : '' }}">
            <a href="{{ route('admin.tickets') }}">
                <i class="feather icon-help-circle"></i>
                {{ __('Support') }}
            </a>
        </li>
    </ul>


    {{-- bottom menu  --}}
    <ul class="sidebar-nav bottom">
        <li>
            <a href="{{ route('admin.logout') }}">
                <i class="feather icon-power"></i>
                {{ __('Sign Out') }}
            </a>
        </li>
    </ul>
</div>
