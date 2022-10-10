<header>
<div class="container">
	<div class="humbager">
		<i class="ion-navicon-round"></i>
	</div>
    <!-- Mobile menu -->


	<div class="logo">
		<a href="/">
			<img src="/assets/images/logo.png" class="img-responsive">
		</a>
	</div>
    <!-- logo -->


	<!-- search -->
	<div class="header-search hidden-xs">
		<form class="_form" action="search" role="search">
			<div class="form-group">
				<div class="form-group has-feedback">
					<input type="text"
						name="q"
						class="form-control input-lg"
						placeholder="Search for projects or tickets" />
				</div>
			</div>
		</form>
	</div>
    <!-- search -->

	<!-- top right -->
	<ul class="nav header-links navbar-right">
		<li class="organization bold dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				{{ session('organization') ? session('organization')->name : 'Organization' }}
			</a>

			<ul class="dropdown-menu pull-left" aria-labelledby="dropdownMenu1">
				<li>
					<a href="/organizations/{{ session('organization')->code }}">
						Organization
					</a>
				</li>
				<li>
					<a href="/members">
						Members
					</a>
				</li>
				<li>
					<a href="/organizations/{{ session('organization')->code }}/settings">
						Settings
					</a>
				</li>

				<li role="separator" class="divider"></li>
				<li><a href="/organization">Switch Organization</a></li>
				<li><a href="/organizations/create">Add Organization</a></li>
			</ul>
		</li>

		<li class="parameters">
			<a href="/notifications" id="icone">
				<i class="notifications-count ion-android-notifications"></i>
			</a>
			<a href="" title="notification number">
				<notifications-badge :user= "{{ json_encode(Auth::user()) }}"></notifications-badge>
			</a>
		</li>
		<li class="parameters">
			<a href="#" class="notification-holder">
				<span class="notifications">
					<i class="param ion-help-circled"></i>
				</span>
			</a>
		</li>
	</ul>

</div>
</header>
