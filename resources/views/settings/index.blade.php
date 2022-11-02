@extends('admin-dashboard.layouts.app')

@section('site_title', 'Permissions Manager')

@section('content')
  @php $agent = new Jenssegers\Agent\Agent(); @endphp

    <div class="row pt-4 pr-4 pb-4 @if ($agent->isMobile()) pl-4 @endif">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">

            {!! laraflash()->render() !!}

            <div class="card">
                <div class="card-header">
                    Amount of likes for making Featured
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 col-sm-12 col-md-6 col-lg-6">
                            {!! Form::open(['url' => route('admin.amounOfLike'), 'method' => 'post', 'data-parsley-validate']) !!}
                            <div class="row">
                                <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4">
                                    {!! Form::label('Number of Likes') !!} *
                                    {!! Form::Number('number', $number_of_likes, ['class' => 'form-control', 'required']) !!}
                                </div>
                                <!-- /.form-group col-12 col-sm-6 col-md-4 col-lg-4 -->
                                <div class="form-group col-12">
                                    {!! Form::submit('Save Changes', ['class' => 'btn btn-success']) !!}
                                </div>
                                <!-- /.form-group col-12 -->
                            </div>
                            <!-- /.row -->
                            {!! Form::close() !!}
                        </div>
                        <div class="col-6 col-sm-12 col-md-6 col-lg-6">
                            {!! Form::open(['url' => route('admin.makeFeaturedByLikes'), 'method' => 'post', 'data-parsley-validate']) !!}
                            <div class="row">
                                <div class="form-group col-12">
                                    {!! Form::submit('Make Featured', ['class' => 'btn btn-primary']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <a  class="btn btn-info" href="{{ route('admin.admin-featuredIdeas') }}">Goto Featured Ideas</a>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    
                </div>
                <div class="card-footer">
                    
                </div>
            </div>

        </div>
        <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
    </div>
    <!-- /.row -->
@endsection
