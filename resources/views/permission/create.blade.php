@extends('admin-dashboard.layouts.app')

@section('site_title', 'Create Permission')

@section('content')
  @php $agent = new Jenssegers\Agent\Agent(); @endphp

    <div class="row pt-4 pr-4 pb-4 @if ($agent->isMobile()) pl-4 @endif">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <h5 class="text-muted">Create Permission</h5>

            @include('errors.validation')

            {!! Form::open(['url' => route('dashboard.permission.store'), 'method' => 'post', 'data-parsley-validate']) !!}
            <div class="row">
                <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4">
                    {!! Form::label('name') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                </div>
                <!-- /.form-group col-12 col-sm-6 col-md-4 col-lg-4 -->

                <div class='form-group col-12'>
                    <p class="text-muted mb-1">Assign Role(s)</p>

                    <div class="row">
                        @foreach ($roles as $role)
                            <div class="col-12 col-sm-4 col-md-3 mb-2">
                                <div class="pretty p-smooth p-bigger p-default">
                                    {!! Form::checkbox('roles[]', $role->id, null,  ['id' => $role->name]) !!}
                                    <div class="state p-primary">
                                        {!! Form::label($role->name, sr($role->name)) !!}
                                    </div>
                                </div>
                            </div>
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
        </div>
        <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
    </div>
    <!-- /.row -->
@endsection
