@extends('admin-dashboard.layouts.app')

@section('site_title', 'Users Manager')


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">


@section('content')
  @php $agent = new Jenssegers\Agent\Agent(); @endphp

	<div class="row pt-4 pr-4 pb-4 @if ($agent->isMobile()) pl-4 @endif">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12">
			{!! laraflash()->render() !!}

			<div class="mb-3">
				<a href="{{ route('dashboard.user.index') }}" class="btn btn-primary mr-1">All Users</a>
				<a href="{{ route('dashboard.user.create') }}"class="btn btn-success">Create User</a>
			</div>
			<!-- /.mb-3 -->

			<div class="table-responsive" style="background:transparent">
				<table class="table table-bordered" id="user_table">
					<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Staff ID</th>
						<th>Cell Number</th>
						<th>Email Address</th>
						<th>Designation</th>
						<th>Assigned Role(s)</th>
						<th>Manage</th>
					</tr>
					</thead>

					<tbody>
					@unless (empty($users))
						@foreach ($users as $user)
							<tr>
								<td style="width: 4rem;"><img src="{{asset($user->profile_picture)}}" alt="" class="img-fluid"></td>
								<td>
									<a href="{{ route('dashboard.user.edit', $user->uuid) }}">{{ sr($user->first_name) }} {{ sr($user->last_name) }}</a>
								</td>
								<td>{{ $user->staff_id }}</td>
								<td><a href="tel:{{ $user->cell_number }}">{{ $user->cell_number }}</a></td>
								<td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
								<td>{{ $user->designation }}</td>
								<td>{{ sr(implode(', ', $user->roles()->orderBy('id')->pluck('name')->toArray())) }}</td>
								<td><span data-toggle="tooltip" data-placement="top" title="Email Password"><a
												href="{{ route('dashboard.user.email-password', $user->uuid) }}" class="btn btn-info btn-sm mr-2">&#9993;</a></span>
									<a href="{{ route('dashboard.user.edit', $user->uuid) }}" class="btn btn-primary btn-sm">Update</a></td>
							</tr>
						@endforeach
					@endunless
					</tbody>
				</table>
				<!-- /.table table-bordered table-striped -->
			</div>
			<!-- /.table-responsive -->

			{{ $users->links() }}
		</div>
		<!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
	</div>
	<!-- /.row -->
@endsection

@section('customJS')
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script> 
	
	<script>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
		});

		$(document).ready(function() {
			$('#user_table').dataTable();
		} );
	</script>
@endsection
