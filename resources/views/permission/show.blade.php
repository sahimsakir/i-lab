@extends('admin-dashboard.layouts.app')

@section('site_title', 'Show Permission')

@section('content')
  @php $agent = new Jenssegers\Agent\Agent(); @endphp

    <div class="row pt-4 pr-4 pb-4 @if ($agent->isMobile()) pl-4 @endif">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            {!! laraflash()->render() !!}

            <div class="mb-3">
                <a href="{{ route('dashboard.permission.index') }}" class="btn btn-primary mr-1">All Permissions</a><a href="{{ route('dashboard.permission.create') }}" class="btn btn-success">Create Permission</a>
            </div>
            <!-- /.mb-3 -->
        </div>
        <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
    </div>
    <!-- /.row -->
@endsection
