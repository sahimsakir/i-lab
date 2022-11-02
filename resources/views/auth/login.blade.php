@extends('layouts.single-page-app')

@section('site_title', 'Account Login')

@section('bg_image', 'bg-login-page full-height')

@section('content')
    <div class="row" style="margin-top: 8vh;">
        <div class="col-12 col-sm-4 offset-sm-1 col-md-3 offset-md-1 col-lg-3 offset-lg-1">
            <div class="mb-5 text-center">
                <a href="{{ route('dashboard.index') }}"><img src="{{ asset('img/home_logo.png') }}" alt="" width="150"></a>
            </div>
            <!-- /.mb-4 -->

			@include('errors.validation')

			{!! laraflash()->render() !!}

            {!! Form::open(['url' => route('account.login'), 'method' => 'post']) !!}
            <div class="input-group mb-3">
                {!! Form::email('email', null, ['class' => 'form-control form-control-lg login-form-control', 'required', 'placeholder' => 'Email Address']) !!}

                <div class="input-group-append">
                    <span class="input-group-text"><img src="{{ asset('img/user.svg') }}" height="20" alt=""></span>
                </div>
            </div>
            <!-- /.form-group -->

            <div class="input-group mb-4">
                {!! Form::password('password', ['class' => 'form-control form-control-lg login-form-control', 'required', 'placeholder' => 'Password']) !!}

                <div class="input-group-append">
                    <span class="input-group-text"><img src="{{ asset('img/password.svg') }}" height="20" alt=""></span>
                </div>
            </div>
            <!-- /.form-group -->

            <div class="form-group mb-4">
                <div class="pretty p-default p-smooth p-bigger">
                    {!! Form::checkbox('remember', '1', null,  ['id' => 'remember']) !!}
                    <div class="state p-success">
                        <label>Remember Me</label>
                    </div>
                </div>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
                {!! Form::submit('Account Login', ['class' => 'btn btn-purple btn-block font-weight-bold']) !!}
            </div>
            <!-- /.form-group -->

            <div class="form-group text-center">
                <a href="{{ route('account.password.request') }}" class="text-deep-purple">{{ __('Forgot Password?') }}</a>
            </div>
            <!-- /.form-group -->

            {!! Form::close() !!}
        </div>
        <!-- /.col-4 -->
    </div>
    <!-- /.row -->
@endsection
