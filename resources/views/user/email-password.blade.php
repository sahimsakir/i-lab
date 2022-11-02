@extends('admin-dashboard.layouts.app')

@section('site_title', 'Email Users Password')

@section('content')
  @php $agent = new Jenssegers\Agent\Agent(); @endphp

	<div class="row pt-4 pr-4 pb-4 @if ($agent->isMobile()) pl-4 @endif">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12">
			{!! laraflash()->render() !!}

			<h5 class="text-muted mb-4">Email Users Password for, {{ $user->first_name }} {{ $user->last_name }}</h5>

			@include('errors.validation')

			{!! Form::open(['url' => route('dashboard.user.send-email-password', $user->uuid), 'method' => 'post', 'data-parsley-validate']) !!}
			<div class="row">
				<div class="form-group col-12 col-sm-6 col-md-4 col-lg-4">
					{!! Form::label('password') !!}
					{!! Form::password('password', ['class' => 'form-control', 'required', 'placeholder' => '5c6^M*q!']) !!}
				</div>
				<!-- /.form-group col-12 col-sm-6 col-md-4 col-lg-4 -->
			</div>

			<div class="row">
				<div class="form-group col-12">
					{!! Form::submit('Send Password to Users Email', ['class' => 'btn btn-success']) !!}
				</div>
				<!-- /.form-group col-12 -->
			</div>
			<!-- /.row -->
			{!! Form::close() !!}
		</div>
		<!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
	</div>
	<!-- /.row -->
@endsection

@section('customJS')
	<script>
		//has uppercase
		window.Parsley.addValidator('uppercase', {
			requirementType: 'number',
			validateString: function (value, requirement) {
				const uppercases = value.match(/[A-Z]/g) || [];
				return uppercases.length >= requirement;
			},
			messages: {
				en: 'Your password must contain at least (%s) uppercase letter.',
			},
		});

		//has lowercase
		window.Parsley.addValidator('lowercase', {
			requirementType: 'number',
			validateString: function (value, requirement) {
				const lowecases = value.match(/[a-z]/g) || [];
				return lowecases.length >= requirement;
			},
			messages: {
				en: 'Your password must contain at least (%s) lowercase letter.',
			},
		});

		//has number
		window.Parsley.addValidator('number', {
			requirementType: 'number',
			validateString: function (value, requirement) {
				const numbers = value.match(/[0-9]/g) || [];
				return numbers.length >= requirement;
			},
			messages: {
				en: 'Your password must contain at least (%s) number.',
			},
		});

		//has special char
		window.Parsley.addValidator('special', {
			requirementType: 'number',
			validateString: function (value, requirement) {
				const specials = value.match(/[^a-zA-Z0-9]/g) || [];
				return specials.length >= requirement;
			},
			messages: {
				en: 'Your password must contain at least (%s) special characters.',
			},
		});
	</script>
@endsection
