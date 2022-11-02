@extends('admin-dashboard.layouts.app')

@section('site_title', 'Permissions Manager')

@section('content')
  @php $agent = new Jenssegers\Agent\Agent(); @endphp

    <div class="row pt-4 pr-4 pb-4 @if ($agent->isMobile()) pl-4 @endif">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">

            {!! laraflash()->render() !!}

            <div class="mb-3">
                <a href="{{ route('dashboard.permission.index') }}" class="btn btn-primary mr-1">All Permissions</a><a href="{{ route('dashboard.permission.create') }}" class="btn btn-success">Create Permission</a>
            </div>
            <!-- /.mb-3 -->

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Permission Name</th>
                        <th>Assigned Role(s)</th>
                        <th>Manage</th>
                    </tr>
                    </thead>

                    <tbody>
                    @unless (empty($permissions))
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $permission->id }}</td>
                                <td><a href="{{ route('dashboard.permission.edit', $permission->uuid) }}">{{ sr($permission->name) }}</a></td>
                                <td>{{ sr(implode(', ', $permission->roles()->orderBy('id')->pluck('name')->toArray())) }}</td>
                                <td><a href="{{ route('dashboard.permission.edit', $permission->uuid) }}" class="btn btn-primary btn-sm">Edit</a></td>
                            </tr>
                        @endforeach
                    @endunless
                    </tbody>
                </table>
                <!-- /.table table-bordered table-striped -->
            </div>
            <!-- /.table-responsive -->

            {{ $permissions->links() }}

        </div>
        <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
    </div>
    <!-- /.row -->
@endsection
