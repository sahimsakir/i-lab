@extends('layouts.app')

@section('site_title', 'My Profile')

@section('bg_image', 'profile-page full-height')

@section('content')
    <div class="row py-3">
        <div class="col-12 col-sm-10 col-md-6 offset-sm-1 offset-md-1 col-lg-6 offset-lg-1 p-5" style="-webkit-box-shadow:0 0 10px 2px rgba(0,62,145,0.15);-moz-box-shadow:0 0 10px 2px rgba(0,62,145,0.15);box-shadow:0 0 10px 2px rgba(0,62,145,0.15);">
            <div class="mb-4">
				@if (auth()->user()->profile_picture != null || !empty(auth()->user()->profile_picture))
						<img src="{{ asset(auth()->user()->profile_picture) }}" alt="Profile Picture" class="rounded-circle" height="100">
				@else
					<img src="{{ asset('img/profile-picture-placeholder.svg') }}" alt="Profile Picture" class="rounded-circle" height="100">
				@endif
            </div>
            <!-- /.mb-4 -->

            <div class="mb-4">
                <h3 class="text-uppercase font-weight-bold" style="color: #FFB100">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h3>
            </div>
            <!-- /.mb-5 -->

            <div class="mb-5">
                <strong class="text-uppercase" style="color: #432BC4;">Contact Information</strong>
                <hr class="hr" style="border-top: 1px solid #C9F5FF;">
                <!-- /.hr -->

                <p class="mb-2" style="color: #414141">Email: <strong>{{ auth()->user()->email }}</strong></p>
                <p class="mb-2" style="color: #414141">Cell Number: <strong>{{ auth()->user()->cell_number }}</strong></p>
            </div>
            <!-- /.mb-3 -->

            <div class="mb-2">
                <div class="row">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-10"><strong class="text-uppercase" style="color: #432BC4;">Other Information</strong></div>
                    <!-- /.col-12 col-sm-10 col-md-10 col-lg-10 -->
                    <div class="col-12 col-sm-2 col-md-2 col-lg-2 text-right">
                        <a href="{{ route('dashboard.update-my-profile') }}" style="color: #0093FF;font-weight: 600;">Edit</a></div>
                    <!-- /.col-12 col-sm-2 col-md-2 col-lg-2 text-right -->
                </div>
                <!-- /.row -->

                <hr class="hr" style="border-top: 1px solid #C9F5FF;">
                <!-- /.hr -->

                <p class="mb-2" style="color: #414141">Designation: <strong>{{ auth()->user()->designation }}</strong></p>
                <p class="mb-2" style="color: #414141">Team: <strong>{{ auth()->user()->team }}</strong></p>
            </div>
            <!-- /.mb-3 -->
        </div>
        <!-- /.col-12 col-sm-10 col-md-7 col-lg-7 -->
    </div>
    <!-- /.row -->
@endsection
