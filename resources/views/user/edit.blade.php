@extends('admin-dashboard.layouts.app')

@section('site_title', 'Edit User')

@section('content')
  @php $agent = new Jenssegers\Agent\Agent(); @endphp

  <div class="row pt-4 pr-4 pb-4 @if ($agent->isMobile()) pl-4 @endif">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
      {!! laraflash()->render() !!}

      <h5 class="text-muted">Edit User</h5>

      @include('errors.validation')

      @unless (empty($user))
        {!! Form::open(['url' => route('dashboard.user.update', $user->uuid), 'method' => 'put', 'enctype' => 'multipart/form-data', 'data-parsley-validate']) !!}
        <div class="row">
          <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4">
            {!! Form::label('is_active', 'Account Status') !!}
            {!! Form::select('is_active', ['1' => 'Active', '0' => 'Inactive'] , $user->is_active) !!}
          </div>
          <!-- /.form-group col-12 col-sm-6 col-md-4 col-lg-4 -->

          <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4">
            {!! Form::label('staff_id') !!}
            {!! Form::text('staff_id', $user->staff_id, ['class' => 'form-control', 'required']) !!}
          </div>
          <!-- /.form-group col-12 col-sm-6 col-md-4 col-lg-4 -->

          <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4">
            {!! Form::label('profile_picture') !!}
            {!! Form::file('profile_picture', ['class' => 'form-control-file']) !!}
          </div>
          <!-- /.form-group col-12 col-sm-6 col-md-4 col-lg-4 -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4">
            {!! Form::label('first_name') !!}
            {!! Form::text('first_name', $user->first_name, ['class' => 'form-control', 'required']) !!}
          </div>
          <!-- /.form-group col-12 col-sm-6 col-md-4 col-lg-4 -->

          <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4">
            {!! Form::label('last_name') !!}
            {!! Form::text('last_name', $user->last_name, ['class' => 'form-control', 'required']) !!}
          </div>
          <!-- /.form-group col-12 col-sm-6 col-md-4 col-lg-4 -->

          <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4">
            {!! Form::label('email') !!}
            {!! Form::email('email', $user->email, ['class' => 'form-control', 'required']) !!}
          </div>
          <!-- /.form-group col-12 col-sm-6 col-md-4 col-lg-4 -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4">
            {!! Form::label('cell_number') !!}
            {!! Form::text('cell_number', $user->cell_number, ['class' => 'form-control cell-number']) !!}
          </div>
          <!-- /.form-group col-12 col-sm-6 col-md-4 col-lg-4 -->

          <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4">
            {!! Form::label('designation') !!}
            {!! Form::text('designation', $user->designation, ['class' => 'form-control']) !!}
          </div>
          <!-- /.form-group col-12 col-sm-6 col-md-4 col-lg-4 -->

          <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4">
            {!! Form::label('team') !!}
            {!! Form::select('team', ['Dhaka Region' => 'Dhaka Region','Chittagong Region' => 'Chittagong Region','Khulna Region' => 'Khulna Region','Sylhet Region' => 'Sylhet Region','Rajshahi Region' => 'Rajshahi Region','Activation' => 'Activation','Business Development' => 'Business Development','Brands' => 'Brands','SP&I' => 'SP&I','Marketing Finance' => 'Marketing Finance','Marketing HR' => 'Marketing HR','MSD' => 'MSD'] , $user->team , ['class' => 'form-control', 'title' => 'Select Team', ]) !!}
          </div>
          <!-- /.form-group col-12 col-sm-6 col-md-4 col-lg-4 -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class='form-group col-12'>
            <p class="text-muted mb-1">Assign Account Role(s)</p>

            <div class="row">
              @foreach ($roles as $role)
                @if($user->hasAnyRole($role->name))
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
        </div>
        <!-- /.row -->

        <hr>

        <div class="row">
          <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4">
            {!! Form::label('password') !!}
            {!! Form::password('password', ['class' => 'form-control', 'data-parsley-minlength' => '8', 'data-parsley-uppercase' => '1', 'data-parsley-lowercase' => '1', 'data-parsley-number' => '1', 'data-parsley-special' => '1']) !!}
          </div>
          <!-- /.form-group col-12 col-sm-6 col-md-4 col-lg-4 -->

          <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4">
            {!! Form::label('password_confirmation') !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'data-parsley-equalto' => '#password', 'data-parsley-minlength' => '8']) !!}
          </div>
          <!-- /.form-group col-12 col-sm-6 col-md-4 col-lg-4 -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="form-group col-12">
            {!! Form::submit('Save Changes', ['class' => 'btn btn-success']) !!}
          </div>
          <!-- /.form-group col-12 -->
        </div>
        <!-- /.row -->
        {!! Form::close() !!}
      @endunless


      <hr class="hr">
      <!-- /.hr -->
      <div class="card-title text-danger">Danger Zone</div>
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

              {!! Form::open(['url' => route('dashboard.user.destroy', $user->uuid), 'method' => 'delete', 'id' => 'delete-form']) !!}
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

@section('customJS')
  <script>
    //has uppercase
    window.Parsley.addValidator('uppercase', {
      requirementType: 'number',
      validateString: function(value, requirement) {
        var uppercases = value.match(/[A-Z]/g) || [];
        return uppercases.length >= requirement;
      },
      messages: {
        en: 'Your password must contain at least (%s) uppercase letter.'
      }
    });

    //has lowercase
    window.Parsley.addValidator('lowercase', {
      requirementType: 'number',
      validateString: function(value, requirement) {
        var lowecases = value.match(/[a-z]/g) || [];
        return lowecases.length >= requirement;
      },
      messages: {
        en: 'Your password must contain at least (%s) lowercase letter.'
      }
    });

    //has number
    window.Parsley.addValidator('number', {
      requirementType: 'number',
      validateString: function(value, requirement) {
        var numbers = value.match(/[0-9]/g) || [];
        return numbers.length >= requirement;
      },
      messages: {
        en: 'Your password must contain at least (%s) number.'
      }
    });

    //has special char
    window.Parsley.addValidator('special', {
      requirementType: 'number',
      validateString: function(value, requirement) {
        var specials = value.match(/[^a-zA-Z0-9]/g) || [];
        return specials.length >= requirement;
      },
      messages: {
        en: 'Your password must contain at least (%s) special characters.'
      }
    });
  </script>
@endsection
