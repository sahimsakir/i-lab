<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@2/dist/Chart.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">


</head>
<body>
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
                            @foreach ($ideas as $index => $idea)
                                <tr>
                                    <td>{{$index+1}}</td>
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


    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    
    <script>
        $(document).ready( function () {
            $('#table_id').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'print', 'pdf','excel'
                ],
                select:true,
            });
        } );
    </script>
</body>
</html>