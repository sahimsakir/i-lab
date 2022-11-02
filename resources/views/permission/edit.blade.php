@extends('admin-dashboard.layouts.app')

@section('site_title', 'Edit Permission')

@section('content')
  @php $agent = new Jenssegers\Agent\Agent(); @endphp

    <div class="row pt-4 pr-4 pb-4 @if ($agent->isMobile()) pl-4 @endif">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">


            {!! laraflash()->render() !!}

            <h5 class="text-muted">Edit Permission</h5>

            @include('errors.validation')

            {!! Form::open(['url' => route('dashboard.permission.update', $permission->uuid), 'method' => 'put', 'data-parsley-validate']) !!}
            <div class="row">
                <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4">
                    {!! Form::label('name') !!}
                    {!! Form::text('name', $permission->name, ['class' => 'form-control', 'required']) !!}
                </div>
                <!-- /.form-group col-12 col-sm-6 col-md-4 col-lg-4 -->

                <div class='form-group col-12'>
                    <p class="text-muted mb-1">Assign Role(s)</p>

                    <div class="row">
                        @foreach ($roles as $role)
                            @if($permission->hasAnyRole($role->name))
                                <div class="col-12 col-sm-4 col-md-3 mb-2">
                                    <div class="pretty p-smooth p-bigger p-default">
                                        {!! Form::checkbox('roles[]', $role->id, true,  ['id' => $role->name]) !!}
                                        <div class="state p-primary">
                                            {!! Form::label($role->name, sr($role->name)) !!}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-12 col-sm-4 col-md-3 mb-2">
                                    <div class="pretty p-smooth p-bigger p-default">
                                        {!! Form::checkbox('roles[]', $role->id, false,  ['id' => $role->name]) !!}
                                        <div class="state p-primary">
                                            {!! Form::label($role->name, sr($role->name)) !!}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="form-group col-12">
                    {!! Form::submit('Save Changes', ['class' => 'btn btn-success']) !!}
                </div>
                <!-- /.form-group col-12 -->
            </div>
            <!-- /.row -->
            {!! Form::close() !!}


            <hr class="hr">
            <!-- /.hr -->
            <h5 class="card-title text-danger">Danger Zone</h5>
            <!-- /.card-title -->

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalForDelete">Delete</button>

            <!-- Modal -->
            <div class="modal fade" id="modalForDelete" tabindex="-1" role="dialog" aria-labelledby="modalForDeleteLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalForDeleteLabel">Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="text-danger">Careful, Once Deleted, There is no Rollback!</p>
                            <!-- /.text-danger -->

                            {!! Form::open(['url' => route('dashboard.permission.destroy', $permission->uuid), 'method' => 'delete', 'id' => 'delete-form']) !!}
                            {!! Form::close() !!}
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" form="delete-form">Delete</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
    </div>
    <!-- /.row -->
@endsection
