<?php
use Carbon\Carbon;
?>
@extends('admin-dashboard.layouts.app')

@section('site_title', 'Print All Ideas')

@section('header_tag')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@2/dist/Chart.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">

@endsection

@section('bg_image', 'admin-page')


@section('content')
@php $agent = new Jenssegers\Agent\Agent(); @endphp



<div class="row pt-3 pb-3 pl-4 pr-4 admin-dashboard-right-section">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="col-12 col-12 col-md-12 col-lg-12">
                <table id="table_id" class="display table" >
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Staff Id.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Idea Topic</th>
                            <th>Idea Title</th>
                            <th>Idea Pitch</th>
                            {{-- <th>Idea Description</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ideas as $idea)
                            <tr>
                                <td>{{$idea->id}}</td>
                                <td>{{$idea->user->staff_id}}</td>
                                <td>{{$idea->user->first_name}} {{$idea->user->last_name}}</td>
                                <td>{{$idea->user->email}}</td>
                                <td>{{$idea->topic}}</td>
                                <td>{{$idea->title}}</td>
                                <td>{{$idea->elevator_pitch}}</td>
                                {{-- <td>{{$idea->description}}</td> --}}
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        <!-- /.col-12 col-12 col-md-12 col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
</div>










@endsection



@section('customJS')

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

<script>

    $(document).ready( function () {
        $('#table_id').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'print', 'pdf','excel'
            ]
        });
    } );
</script>

@endsection
