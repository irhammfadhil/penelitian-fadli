<nav class="navbar navbar-expand navbar-light navbar-bg">
	<a class="sidebar-toggle js-sidebar-toggle">
		<i class="hamburger align-self-center"></i>
	</a>

	<div class="navbar-collapse collapse">
		<ul class="navbar-nav navbar-align">
		
			<li class="nav-item dropdown">
				<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
					<i class="align-middle" data-feather="settings"></i>
				</a>

				<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
					<img src="{{asset('person.png')}}" class="avatar img-fluid rounded me-1" alt="Charles Hall" /> <span class="text-dark">{{Auth::user()->username}}</span>
				</a>
				<div class="dropdown-menu dropdown-menu-end">
					@if(Auth::user()->is_admin == 0)
					<a class="dropdown-item" href="/dashboard-user"><i class="align-middle me-1" data-feather="user"></i> Profil</a>
					@else
					<a class="dropdown-item" href="/dashboard-admin"><i class="align-middle me-1" data-feather="user"></i> Profil</a>
					@endif
					<a class="dropdown-item" href="/change-password"><i class="align-middle me-1" data-feather="settings"></i> Ubah Password</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="/logout">Log out</a>
				</div>
			</li>
		</ul>
	</div>
</nav>