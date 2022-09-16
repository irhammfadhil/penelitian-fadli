<nav id="sidebar" class="sidebar js-sidebar">
	<div class="sidebar-content js-simplebar">
		<a class="sidebar-brand" href="index.html">
			<span class="align-middle">Simetri</span>
		</a>

		<ul class="sidebar-nav">
			<li class="sidebar-header">
				Halaman
			</li>
			@if(Auth::user()->is_admin == 0)

			@if(str_contains(url()->current(), '/dashboard-user'))

			<li class="sidebar-item active">
				<a class="sidebar-link" href="/dashboard/user">
					<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
				</a>
			</li>
			@else
			<li class="sidebar-item">
				<a class="sidebar-link" href="/dashboard/user">
					<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
				</a>
			</li>
			@endif

			@if(str_contains(url()->current(), '/biodata') || str_contains(url()->current(), '/informed-consent') || str_contains(url()->current(), '/foto-gigi') || str_contains(url()->current(), '/finalisasi'))
			<li class="sidebar-item active">
				<a class="sidebar-link" href="/biodata">
					<i class="align-middle" data-feather="user"></i> <span class="align-middle">Biodata dan Foto Gigi</span>
				</a>
			</li>
			@else
			<li class="sidebar-item">
				<a class="sidebar-link" href="/biodata">
					<i class="align-middle" data-feather="user"></i> <span class="align-middle">Biodata dan Foto Gigi</span>
				</a>
			</li>
			@endif

			@if(str_contains(url()->current(), '/screening-covid'))
			<li class="sidebar-item active">
				<a class="sidebar-link" href="/screening-covid">
					<i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Screening COVID-19</span>
				</a>
			</li>
			@else
			<li class="sidebar-item">
				<a class="sidebar-link" href="/screening-covid">
					<i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Screening COVID-19</span>
				</a>
			</li>
			@endif

			@if(str_contains(url()->current(), '/komentar'))
			<li class="sidebar-item active">
				<a class="sidebar-link" href="/komentar">
					<i class="align-middle" data-feather="file"></i> <span class="align-middle">Laporan</span>
				</a>
			</li>
			@else
			<li class="sidebar-item">
				<a class="sidebar-link" href="/komentar">
					<i class="align-middle" data-feather="file"></i> <span class="align-middle">Laporan</span>
				</a>
			</li>
			@endif
			@else
			@if(str_contains(url()->current(), '/dashboard/admin'))
			<li class="sidebar-item active">
				<a class="sidebar-link" href="/dashboard/admin">
					<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
				</a>
			</li>
			@else
			<li class="sidebar-item">
				<a class="sidebar-link" href="/dashboard/admin">
					<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
				</a>
			</li>
			@endif
			@if(str_contains(url()->current(), '/daftar-anak'))
			<li class="sidebar-item active">
				<a class="sidebar-link" href="/daftar-anak">
					<i class="align-middle" data-feather="user"></i> <span class="align-middle">Daftar Anak</span>
				</a>
			</li>
			@else
			<li class="sidebar-item">
				<a class="sidebar-link" href="/daftar-anak">
					<i class="align-middle" data-feather="user"></i> <span class="align-middle">Daftar Anak</span>
				</a>
			</li>
			@endif
			@if(str_contains(url()->current(), '/admin/artikel'))
			<li class="sidebar-item active">
				<a class="sidebar-link" href="/admin/artikel">
					<i class="align-middle" data-feather="file"></i> <span class="align-middle">Daftar Artikel</span>
				</a>
			</li>
			@else
			<li class="sidebar-item">
				<a class="sidebar-link" href="/admin/artikel">
					<i class="align-middle" data-feather="file"></i> <span class="align-middle">Daftar Artikel</span>
				</a>
			</li>
			@endif
			@if(str_contains(url()->current(), '/daftar-user'))
			<li class="sidebar-item active">
				<a class="sidebar-link" href="/daftar-user">
					<i class="align-middle" data-feather="user"></i> <span class="align-middle">Daftar User</span>
				</a>
			</li>
			@else
			<li class="sidebar-item">
				<a class="sidebar-link" href="/daftar-user">
					<i class="align-middle" data-feather="user"></i> <span class="align-middle">Daftar User</span>
				</a>
			</li>
			@endif
			@if(Route::is('report'))
			<li class="sidebar-item active">
				<a class="sidebar-link" href="/report">
					<i class="align-middle" data-feather="file"></i> <span class="align-middle">Laporan</span>
				</a>
			</li>
			@else
			<li class="sidebar-item">
				<a class="sidebar-link" href="/report">
					<i class="align-middle" data-feather="file"></i> <span class="align-middle">Laporan</span>
				</a>
			</li>
			@endif
			@if(Route::is('reportBySchool') || Route::is('reportBySchoolSubmit'))
			<li class="sidebar-item active">
				<a class="sidebar-link" href="/report/bySchool">
					<i class="align-middle" data-feather="file"></i> <span class="align-middle">Laporan Berdasarkan Sekolah</span>
				</a>
			</li>
			@else
			<li class="sidebar-item">
				<a class="sidebar-link" href="/report/bySchool">
					<i class="align-middle" data-feather="file"></i> <span class="align-middle">Laporan Berdasarkan Sekolah</span>
				</a>
			</li>
			@endif
		@endif
	</div>
</nav>