<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
	    <div class="navbar-header">
	        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="flaticon-menu-mobile"></span>
	        </button>

	        <a href="/" class="navbar-brand">{{ config('app.name') }}</a>
	    </div>
	    <div id="navbar" class="navbar-collapse collapse">
	        <ul class="nav navbar-nav navbar-right">
	            <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="/">Home</a></li>
	            <li class="{{ Request::is('cars') ? 'active' : '' }}"><a href="/cars">Cars</a></li>
	            <li class="{{ Request::is('services') ? 'active' : '' }}"><a href="/services">Services</a></li>
	            <li class="{{ Request::is('about') ? 'active' : '' }}"><a href="/about">About</a></li>
	            <li class="{{ Request::is('contact') ? 'active' : '' }}"><a href="/contact">Contact</a></li>

	            <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
	                <a href="/dashboard" class="btn btn-rentals">
	                    @if (Auth::check())
	                        Account
	                    @else
	                        Sign In
	                    @endif
	                </a>
	            </li>
	        </ul>
	    </div>
	</div>
</nav>
