@extends('layouts.app')

@section('site_title', 'Edit Idea')

@section('content')

<style type="text/css">
    #progress-wrp {
       height: 20%;
       margin-top: 0%;
       margin-left: 3%;
       /* border: 1px solid #0099CC; */
       padding: 1px;
       position: relative;
       border-radius: 3px;
       text-align: left;
       background: #fff;
       box-shadow: inset 1px 3px 6px rgba(0, 0, 0, 0.12);
   }

   #progress-wrp .progress-bar{
       height: 20px;
       border-radius: 3px;
       background-color: #61E183;
       width: 0px;
       box-shadow: inset 1px 1px 10px rgba(0, 0, 0, 0.11);
   }
   #progress-wrp .status{
       top:0px;
       left:42%;
       position:absolute;
       display:inline-block;
       color: #000;
	   font-weight: bolder;
   }
   .pull-right{
    float: right;
    margin-right: 10px;
    }
</style>

@php $agent = new Jenssegers\Agent\Agent(); @endphp

    <div class="row">
        <div class="col-12 col-sm-10 col-md-9 offset-md-1 col lg-9 offset-lg-1">
            {!! laraflash()->render() !!}

            @include('errors.validation')

            {!! Form::open(['url' => route('dashboard.idea.update', $idea->uuid), 'method' => 'put', 'enctype' => 'multipart/form-data']) !!}

            <div class="row">
                <div class="form-group col-12 col-sm-4 col-md-4 col-lg-4">
                    {!! Form::label('topic', 'Idea Topic', ['class' => 'font-weight-bold custom-form-control-label']) !!}
                    {!! Form::select('topic', ['Distribution' => 'Distribution','Consumer Engagement' => 'Consumer Engagement','B2B' => 'B2B','Automation' => 'Automation','Merchandising' => 'Merchandising','FF' => 'FF','Research' => 'Research','Channel Management' => 'Channel Management','Product' => 'Product','Pricing and Compliance' => 'Pricing and Compliance','Sales Management' =>'Sales Management','Illicit' => 'Illicit','New Category' => 'New Category','Alternative Revenue' => 'Alternative Revenue','Culture and Way of Work' => 'Culture and Way of Work','Others' => 'Others'] , $idea->topic , ['class' => 'custom-form-control', 'title' => 'Select Idea Topic', 'required']) !!}
                </div>
                <!-- /.form-group col-6 -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6">
                    {!! Form::label('title', 'Idea Title', ['class' => 'font-weight-bold custom-form-control-label']) !!}
                    {!! Form::text('title', $idea->title, ['class' => 'form-control custom-form-control', 'id' => 'title', 'required', 'maxlength' => '120']) !!}
                    <h6 class="pull-right" id="count_message"></h6>
                </div>
                <!-- /.form-group col-12 -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="form-group col-12">
                    {!! Form::label('elevator_pitch', 'Elevator Pitch', ['class' => 'font-weight-bold custom-form-control-label']) !!}
                    {!! Form::textarea('elevator_pitch', $idea->elevator_pitch, ['id' => 'elevator_pitch', 'class' => 'form-control custom-form-control custom-form-control-text-area', 'rows' => '3', 'required', 'maxlength' => '250']) !!}
                    <h6 class="pull-right" id="count_textarea"></h6>
                </div>
                <!-- /.form-group col-12 -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="form-group col-12">
                    {!! Form::label('description', 'Description', ['class' => 'font-weight-bold custom-form-control-label']) !!}
                    {!! Form::textarea('description', $idea->description, ['class' => 'form-control custom-form-control custom-form-control-text-area']) !!}
                </div>
                <!-- /.form-group col-12 -->
            </div>
            <!-- /.row -->

            {{-- <div class="row">
                <div class="form-group col-6">
                    {!! Form::label('file', 'Upload Files (Document/ Video)', ['class' => 'font-weight-bold custom-form-control-label']) !!}
                    {!! Form::file('file', ['class' => 'form-control-file custom-form-control']) !!}
                </div>
                <!-- /.form-group col-6 -->
            </div> --}}
            <div class="row" style="display: none">
                <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6">
                    {{-- {!! Form::label('file', 'Upload Files (Document/ Video)', ['class' => 'font-weight-bold custom-form-control-label']) !!} --}}
                    {{-- {!! Form::file('file', ['class' => 'form-control-file custom-form-control']) !!} --}}
                    <div>Upload (Document/ Video) Limit left: <span style="color: purple;font-weight:bold" id="uploadLimit"></span></div><br>
                    <div class="field_wrapper">
                    <div>
                            <div class="row" style="display: flex; align-items: center;">
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                    <input type="file" id="upload_form" class="form-control-file custom-form-control" name="image[]" value=""/>
                                    {{-- <input type="text" id="idea_id" readonly class="form-control-file custom-form-control" name="idea_id" value=""/> --}}
                                    {!! Form::text('idea_id', $idea->id, ['class' => 'form-control custom-form-control', 'hidden','id'=>'idea_id','required']) !!}
                                </div>
                                <div style="background-color: transparent; @if ($agent->isMobile()) margin-top: 15px; margin-left: 15px; width:90%; @else width:200px;  @endif" id="progress-wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>
                            </div>

                    </div>
                    </div>
                </div>
                <!-- /.form-group col-6 -->
            </div>
            <div class="row pl-3" id="output"></div>
            <!-- /.row -->

            <div class="row">
                <div class="form-group col-12 col-sm-12 col-md-12 col-lg-12 @if (!$agent->isMobile()) text-right @endif">
                    {!! Form::submit('Draft', ['class' => 'btn btn-purple custom-form-control-btn mr-3', 'name' => 'submit_button']) !!}
                    {!! Form::submit('Publish', ['class' => 'btn btn-success custom-form-control-btn', 'name' => 'submit_button']) !!}
                </div>
                <!-- /.form-group col-12 -->
            </div>
            <!-- /.row -->

            {!! Form::close() !!}
        </div>
        <!-- /.col-12 col-sm-12 col-md-12 col lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row mb-3">
        <div class="col-12 col-sm-10 col-md-9 offset-md-1 col-lg-9 offset-lg-1">
            <hr class="hr">
            <!-- /.hr -->

            <div class="mb-2 mt-2">
                <strong class="text-deep-purple font-weight-bold">Files Uploaded</strong>
                <!-- /.text-deep-purple -->
            </div>
            <!-- /.mb-3 mt-2 -->

            <div class="row" id="uploaded_file">
                @unless (empty($idea->uploads()->exists()))
                    @foreach ($idea->uploads as $upload)
                        <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6">
                            <ul class="list-group mb-1">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ asset("/idea/files/$upload->file") }}">{{ $upload->title }} ({{ strtoupper(\File::extension($upload->file)) }})</a>
                                    <span class="badge badge-primary badge-pill">uploaded {{ Carbon\Carbon::parse($upload->created_at)->diffForHumans() }}</span>

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUploadsModal{{ $upload->uuid }}">X</button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteUploadsModal{{ $upload->uuid }}" tabindex="-1" role="dialog" aria-labelledby="deleteUploadsModal{{ $upload->uuid }}Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteUploadsModal{{ $upload->uuid }}Label">Delete File: {{ $upload->title }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-danger">Careful, Once Deleted, There is no Rollback!</p>
                                                    <!-- /.text-danger -->

                                                    {!! Form::open(['url' => route('dashboard.upload.destroy', $upload->uuid), 'method' => 'delete', 'id' => 'delete-upload-form-'.$upload->uuid]) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger" form="delete-upload-form-{{ $upload->uuid }}">Delete</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- /.form-group col-6 -->
                    @endforeach
                @endunless
            </div>

            <hr class="hr">
            <!-- /.hr -->
        </div>
        <!-- /.col-12 col-sm-10 col-md-7 col-lg-7 -->
    </div>
    <!-- /.row mb-3 -->

    <div class="row mb-3">
        <div class="col-12 col-sm-10 col-md-9 offset-md-1 col-lg-9 offset-lg-1">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalForDelete">Delete This Idea</button>

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

                            {!! Form::open(['url' => route('dashboard.idea.destroy', $idea->uuid), 'method' => 'delete', 'id' => 'delete-form-'.$idea->uuid]) !!}
                            {!! Form::close() !!}
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" form="delete-form-{{ $idea->uuid }}">Delete</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-12 col-sm-10 col-md-7 col-lg-7 -->
    </div>
    <!-- /.row mb-3 -->
@endsection

@section('customJS')
    @component('layouts.tinymce')
        @slot('editor')
            #description
        @endslot
    @endcomponent

<script type="text/javascript">
    $(document).ready(function(){

        var max = parseInt($("#title").attr("maxlength"));
        $("#count_message").text($("#title").val().length +"/"+ max);
            $("#title").keyup(function(e){
                let len = $(this).val().length;
                $("#count_message").text(len +"/"+ max);
            if($(this).val().length==max){}
        });

        var maxTextarea = parseInt($("#elevator_pitch").attr("maxlength"));
        $("#count_textarea").text($("#elevator_pitch").val().length +"/"+ maxTextarea);
            $("#elevator_pitch").keyup(function(e){
                let len = $(this).val().length;
                $("#count_textarea").text(len +"/"+ maxTextarea);
            if($(this).val().length==maxTextarea){}
        });


        let asset = '<?php echo asset("/idea/files");?>'

        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var uploaded = $('#uploaded_file'); //Input field wrapper
        var x = 1; //Initial field counter is 1
        var upload_id = [];

        //Once add button is clicked
        var current = document.querySelector(".row input[name='image[]']");
        // var upload_file_id = $(`'#uploaded_file_id_${x}'`);

        //configuration
        var max_file_size           = 70 - '<?php echo $fileSizeCount;?>'; //allowed file size. (1 MB = 1048576)
        var allowed_file_types      = ['image/png', 'image/gif', 'image/jpeg', 'image/pjpeg']; //allowed file types
        var result_output           = '#output'; //ID of an element for response output
        var my_form_id              = '#upload_form'; //ID of an element for response output
        var progress_bar_id         = '#progress-wrp'; //ID of an element for response output
        var total_files_allowed     = 3; //Number files allowed to upload
        var total_files_size        = 0;
        var limitLeft               = 0;

    $('#upload_form').on('click', function(){
        $(progress_bar_id +" .progress-bar").css("width", "0%");
        $(progress_bar_id + " .status").text("0%");
    });

    $('#uploadLimit').html(max_file_size.toFixed(2)+'MB');
    //on form submit
    $(document).on("change","#upload_form", function(event) {
        if($('input[type=file]')[x].files.length){

            let fileSize = getFileSize($('input[type=file]')[x].files[0].size);
            limitLeft = max_file_size - fileSize;
            let proceed = true; //set proceed flag
            let error = []; //errors

            if (limitLeft >= 0) {

            $('#progress-wrp').css({'visibility':'visible'});
            event.preventDefault();
            var formData = new FormData();
            formData.append('image', $('input[type=file]')[x].files[0]);
            formData.append('idea_id', $('#idea_id').val());
            formData.append('topic', $('#topic').val());
            formData.append('title', $('#title').val());
            formData.append('elevator_pitch', $('#elevator_pitch').val());
            formData.append('description', $('#description').val());
            formData.append('size', fileSize);

            //reset progressbar
            $(progress_bar_id +" .progress-bar").css("width", "0%");
            $(progress_bar_id + " .status").text("0%");

            if(!window.File && window.FileReader && window.FileList && window.Blob){ //if browser doesn't supports File API
                error.push("Your browser does not support new File API! Please upgrade."); //push error text
            }else{
                //if everything looks good, proceed with jQuery Ajax
                if(proceed){

                    $.ajax({
                        url : "{{route('dashboard.file-upload')}}",
                        type: "POST",
                        data : formData,
                        headers: {
                            'X-CSRF-TOKEN':  $("[name=_token]").val()
                        },
                        contentType: false,
                        cache: false,
                        processData:false,
                        xhr: function(){
                            //upload Progress
                            var xhr = $.ajaxSettings.xhr();
                            if (xhr.upload) {
                                xhr.upload.addEventListener('progress', function(event) {
                                    var percent = 0;
                                    var position = event.loaded || event.position;
                                    var total = event.total;
                                    if (event.lengthComputable) {
                                        percent = Math.ceil(position / total * 100);
                                        // console.log(percent);
                                    }
                                    //update progressbar
                                    $(progress_bar_id + " .status").text(percent +"%");
                                    $(progress_bar_id +" .progress-bar").css("width", + (percent * 2) +"px");
                                    // $(progress_bar_id +" .status").css("background-color","#fff");
                                }, true);
                            }
                            return xhr;
                        },
                        mimeType:"multipart/form-data"
                        }).done(function(res){ //

                            res = JSON.parse(res);
                            upload_id.push(res.id)
                            $("#uploaded_file_id").val(upload_id);

                            $("#idea_id").val(res.idea_id);

                            $(uploaded).append(uploadedFileShow(res));
                        });

                }
            }

        total_files_size += fileSize;
        max_file_size -= fileSize;
        $('#uploadLimit').html('');
        $('#uploadLimit').html(max_file_size.toFixed(2)+'MB');
        }else{
            error.push( "File is larger than limit left:  "+max_file_size.toFixed(2)+" MB, Try smaller file!"); //push error text
            proceed = false; //set proceed flag to false
        }

        $(result_output).html(""); //reset output
        $(error).each(function(i){ //output any error to output element
            $(result_output).append('<div class="error" style="color: red">'+error[i]+"</div>");
        });
    }
    });

        function uploadedFileShow(upload){
            let fileData = `<div class="form-group col-6">
                    <ul class="list-group mb-1">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="${asset}/${upload.file}" target="_blank">${upload.title}</a>

                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUploadsModal-${upload.uuid}">X</button>

                            <div class="modal fade" id="deleteUploadsModal-${upload.uuid}" tabindex="-1" role="dialog" aria-labelledby="deleteUploadsModal${upload.uuid}Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteUploadsModal${upload.uuid}Label">Delete File: ${upload.title}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-danger">Careful, Once Deleted, There is no Rollback!</p>

                                            <form method="post" action="{{route('dashboard.upload-file-delete')}}" id="delete-upload-form-${upload.uuid}">
                                                <input type="text" hidden readonly class="form-control" value="${upload.uuid}" name="upload_id">
                                                @csrf
                                            <form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger delete" id="delete-${upload_id}" form="delete-upload-form-${upload.uuid}">Delete</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>`;

            return fileData;
        }

        function getFileSize(fileSize){
            let sizeInMB;
            var _size = fileSize;
            var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
            i=0;while(_size>900){_size/=1024;i++;}
            var exactSize = (Math.round(_size*100)/100);

            if (i == 0) {
                sizeInMB = (exactSize / 1e+6);
            }else if(i == 1){
                sizeInMB = (exactSize / 1000);
            }else if(i == 2){
                sizeInMB = exactSize;
            }else{
                sizeInMB = exactSize * 1000;
            }

        return sizeInMB;
    }
    });
</script>
@endsection
