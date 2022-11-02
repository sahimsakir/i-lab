@extends('admin-dashboard.layouts.app')

@section('site_title', 'Roles Manager')

@section('content')
  @php $agent = new Jenssegers\Agent\Agent(); @endphp

    <div class="row pt-4 pr-4 pb-4 @if ($agent->isMobile()) pl-4 @endif">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">

            {!! laraflash()->render() !!}

            <div class="mb-3">
                <a href="{{ route('dashboard.role.index') }}" class="btn btn-primary mr-1">All Roles</a><a href="{{ route('dashboard.role.create') }}" class="btn btn-success">Create Role</a>
            </div>
            <!-- /.mb-3 -->

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Role Name</th>
                        <th>Assigned Permission(s)</th>
                        <th>Manage</th>
                    </tr>
                    </thead>

                    <tbody>
                    @unless (empty($roles))
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td><a href="{{ route('dashboard.role.edit', $role->uuid) }}">{{ sr($role->name) }}</a></td>
                                <td>{{ sr(implode(', ', $role->permissions()->orderBy('id')->pluck('name')->toArray())) }}</td>
                                <td><a href="{{ route('dashboard.role.edit', $role->uuid) }}" class="btn btn-primary btn-sm">Edit</a></td>
                            </tr>
                        @endforeach
                    @endunless
                    </tbody>
                </table>
                <!-- /.table table-bordered table-striped -->
            </div>
            <!-- /.table-responsive -->

            {{ $roles->links() }}

        </div>
        <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
    </div>
    <!-- /.row -->
@endsection
