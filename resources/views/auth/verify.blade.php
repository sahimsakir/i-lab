@extends('layouts.app')

@section('site_title', 'Verify Your Email Address')

@section('bg_image', 'bg-login-page full-height')

@section('content')
    <div class="row" style="margin-top: 8vh;">
        <div class="col-12 col-sm-4 offset-sm-1 col-md-3 offset-md-1 col-lg-3 offset-lg-1">
            <div class="mb-4 text-center">
                <a href="{{ route('dashboard.index') }}"><img src="{{ asset('img/home_logo.png') }}" alt="" width="150"></a>
            </div>
            <!-- /.mb-4 -->

            <div class="mb-4 text-center">
                <h4 class="text-deep-purple">{{ __('Verify Your Email Address') }}</h4>
                <!-- /.text-muted -->
            </div>
            <!-- /.mb-4 -->

            @include('errors.validation')

            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }},

            {!! Form::open(['url' => route('account.verification.resend'), 'method' => 'post']) !!}

            <div class="form-group">
                {!! Form::submit(__('click here to request another'), ['class' => 'btn btn-purple']) !!}
            </div>
            <!-- /.form-group -->

            <div class="form-group">
                Back to <a href="{{ route('account.login') }}" class="text-deep-purple">{{ __('Login Page') }}</a>
            </div>
            <!-- /.form-group -->

            {!! Form::close() !!}
        </div>
        <!-- /.col-4 -->
    </div>
    <!-- /.row -->
@endsection
