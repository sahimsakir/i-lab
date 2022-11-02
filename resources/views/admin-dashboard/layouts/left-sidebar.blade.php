<div class="admin-dashboard-left-sidebar">
    <div class="admin-information-in-sidebar text-center mb-3">
        <div class="mb-3">
			<a href="{{ route('admin.admin-dashboard') }}">
			@if (auth()->user()->profile_picture != null || !empty(auth()->user()->profile_picture))
				<img src="{{ asset(auth()->user()->profile_picture) }}" alt="Profile Picture" class="rounded-circle" height="80" style="border: 1px solid #ffffff;">
			@else
				<img src="{{ asset('img/profile-picture-placeholder.svg') }}" alt="Profile Picture" class="rounded-circle" height="80" style="border: 1px solid #ffffff;">
			@endif
			</a>
        </div>
        <!-- /.mb-3 -->

        <div class="admin-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
        <p class="admin-designation mb-0">{{ auth()->user()->designation }}</p>
        <!-- /.mb-0 -->
    </div>
    <!-- /.admin-information-in-sidebar -->

    <div class="left-side-navbar">
        <ul class="left-side-navbar-ul">
            <li class="left-side-navbar-li">
                <a href="{{ route('admin.admin-dashboard') }}" @if (request()->is('secure/admin'))class="active-navbar-item"@endif><img src="{{ asset('img/admin/home-icon.svg') }}" alt=""> Home</a>
            </li>
            <!-- /.left-side-navbar-li -->

            
            <li  class="left-side-navbar-li">
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <img src="{{ asset('img/admin/history-icon.svg') }}" alt=""> Ideas</a>
                <ul class="collapse list-unstyled left-side-navbar-ul left_bar_ul 
                    @if (request()->is('secure/admin/allIdeas') || request()->is('secure/admin/recentMontIdeas') || request()->is('secure/admin/previousMontIdeas') ) show @endif " id="pageSubmenu" >
                    <li class="left-side-navbar-li">
                        <a href="{{ route('admin.admin-allIdeas') }}"  class="left_bar_li_a @if (request()->is('secure/admin/allIdeas')) active-navbar-item @endif"><img src="{{ asset('img/admin/history-icon.svg') }}" alt=""> All Ideas</a>
                    </li>
                    <li class="left-side-navbar-li">
                        <a href="{{ route('admin.admin-recentMontIdeas') }}"  class="left_bar_li_a @if (request()->is('secure/admin/recentMontIdeas')) active-navbar-item @endif"><img src="{{ asset('img/admin/history-icon.svg') }}" alt=""> Recent Month Ideas</a>
                    </li>
                    <li class="left-side-navbar-li">
                        <a href="{{ route('admin.admin-previousMontIdeas') }}"  class="left_bar_li_a @if (request()->is('secure/admin/previousMontIdeas')) active-navbar-item @endif"><img src="{{ asset('img/admin/history-icon.svg') }}" alt=""> Previous Month Ideas</a>
                    </li>
                    
                    <li class="left-side-navbar-li">
                        <a href="{{ route('admin.admin-printAllIdeas') }}"  class="left_bar_li_a @if (request()->is('secure/admin/printAllIdeas')) active-navbar-item @endif"><img src="{{ asset('img/admin/history-icon.svg') }}" alt=""> Print All Ideas</a>
                    </li>
                </ul>
            </li>
            <!-- /.left-side-navbar-li -->

            <li  class="left-side-navbar-li">
                <a href="#pageSubmenu_OI" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <img src="{{ asset('img/admin/all-ideas-icon.svg') }}" alt="">listed Ideas</a>
                <ul class="collapse list-unstyled left-side-navbar-ul left_bar_ul
                    @if (request()->is('secure/admin/pilotedIdeas') || request()->is('secure/admin/featuredIdeas') || request()->is('secure/admin/short-listed-idea') ) show @endif " id="pageSubmenu_OI" >
                    <li class="left-side-navbar-li">
                        <a href="{{ route('admin.admin-featuredIdeas') }}"  class="left_bar_li_a @if (request()->is('secure/admin/featuredIdeas')) active-navbar-item @endif"><img src="{{ asset('img/admin/all-ideas-icon.svg') }}" alt=""> Featured Ideas</a>
                    </li>
                    <li class="left-side-navbar-li">
                        <a href="{{ route('admin.admin-pilotedIdeas') }}"  class="left_bar_li_a @if (request()->is('secure/admin/pilotedIdeas')) active-navbar-item @endif"><img src="{{ asset('img/admin/all-ideas-icon.svg') }}" alt=""> Piloted Ideas</a>
                    </li>
                    <li class="left-side-navbar-li">
                        <a href="{{ route('admin.short-listed-idea.index') }}"  class="left_bar_li_a @if (request()->is('secure/admin/short-listed-idea')) active-navbar-item @endif"><img src="{{ asset('img/admin/all-ideas-icon.svg') }}" alt=""> Short-listed Ideas</a>
                    </li>
                    
                </ul>
            </li>
            <!-- /.left-side-navbar-li -->
            <li  class="left-side-navbar-li">
                <a href="#pageSubmenu_user" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <img src="{{ asset('img/admin/user.svg') }}" alt="">Users</a>
                <ul class="collapse list-unstyled left-side-navbar-ul left_bar_ul
                    @if (request()->is('secure/dashboard/user') || request()->is('secure/dashboard/role') || request()->is('secure/dashboard/permission') ) show @endif" id="pageSubmenu_user" >
                    <li class="left-side-navbar-li">
                        <a href="{{ route('dashboard.user.index') }}"  class="left_bar_li_a @if (request()->is('secure/dashboard/user')) active-navbar-item @endif"><img src="{{ asset('img/admin/user.svg') }}" alt=""> Users Manager</a>
                    </li>
                    <li class="left-side-navbar-li">
                        <a href="{{ route('dashboard.role.index') }}"  class="left_bar_li_a @if (request()->is('secure/dashboard/role')) active-navbar-item @endif"><img src="{{ asset('img/admin/user.svg') }}" alt=""> User Roles</a>
                    </li>
                    <li class="left-side-navbar-li">
                        <a href="{{ route('dashboard.permission.index') }}" class=" left_bar_li_a @if (request()->is('secure/dashboard/permission')) active-navbar-item @endif"><img src="{{ asset('img/admin/user.svg') }}" alt=""> User Permissions</a>
                    </li>
                </ul>
            </li>
            <!-- /.left-side-navbar-li -->

            <li class="left-side-navbar-li">
                <a href="{{ route('admin.settings') }}"><img src="{{ asset('img/admin/wheel.svg') }}" alt=""> Settings </a>
            </li>
            <!-- /.left-side-navbar-li -->

            <li class="left-side-navbar-li">
                <a href="{{ route('dashboard.index') }}" target="_blank"><img src="{{ asset('img/admin/home-icon.svg') }}" alt=""> Ideas Homepage</a>
            </li>
            <!-- /.left-side-navbar-li -->

            <li class="mb-3 mt-4"></li>

            <li class="left-side-navbar-li">
                <a href="{{ route('account.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" style="background-color: #1D0045;"><img src="{{ asset('img/admin/logout-icon.svg') }}" alt=""> Logout</a>

                <form id="logout-form" action="{{ route('account.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
            <!-- /.left-side-navbar-li -->
        </ul>
        <!-- /.left-side-navbar-ul -->
    </div>
    <!-- /.left-side-navbar -->
</div>
<!-- /.admin-dashboard-left-sidebar -->
