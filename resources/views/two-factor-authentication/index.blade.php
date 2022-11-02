@extends('layouts.single-page-app')

@section('site_title', 'Two Factor Authentication')

@section('bg_image', 'bg-login-page full-height')

@section('content')
    <div class="row" style="margin-top: 12vh;">
        <div class="col-12 col-sm-4 offset-sm-1 col-md-3 offset-md-1 col-lg-3 offset-lg-1">
            <div class="mb-4 text-center">
                <a href="{{ route('dashboard.index') }}"><img src="{{ asset('img/home_logo.png') }}" alt="" width="100"></a>
            </div>
            <!-- /.mb-4 -->

            <div class="mb-4 text-center">
                <h4 class="text-deep-purple">Two Factor Authentication</h4>
                <!-- /.text-muted -->

                <strong class="text-muted">Please Check Your Registered Email for Two Factor Authentication Token</strong>
            </div>
            <!-- /.mb-4 -->

            @include('errors.validation')

            {!! laraflash()->render() !!}

            {!! Form::open(['url' => route('two_factor_authentication.store'), 'method' => 'post']) !!}
            <div class="input-group mb-3">
                {!! Form::text('token', null, ['class' => 'form-control', 'required', 'minlength' => '7', 'maxlength' => '10', 'placeholder' => 'e.g.: 1234567']) !!}

                <div class="input-group-append">
                    <span class="input-group-text"><img src="{{ asset('img/user.svg') }}" height="20" alt=""></span>
                </div>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
                {!! Form::submit('Verify 2FA Token', ['class' => 'btn btn-purple']) !!}
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
