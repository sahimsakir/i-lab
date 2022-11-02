@extends('layouts.app')

@section('site_title', 'Submit Idea')

@section('bg_image', 'submit-idea-page full-height')

@section('content')
    @php $agent = new Jenssegers\Agent\Agent(); @endphp

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

        #progress-wrp .progress-bar {
            height: 20px;
            border-radius: 3px;
            background-color: #61E183;
            width: 0px;
            box-shadow: inset 1px 1px 10px rgba(0, 0, 0, 0.11);
        }

        #progress-wrp .status {
            top: 0px;
            left: 42%;
            position: absolute;
            display: inline-block;
            color: #000;
            font-weight: bolder;
        }

        .pull-right {
            float: right;
            margin-right: 10px;
        }
    </style>
    <script src="https://kit.fontawesome.com/dfea93c091.js" crossorigin="anonymous"></script>

    <div class="row">
        <div class="col-12 col-sm-10 col-md-9 offset-md-1 col lg-9 offset-lg-1">
            @include('errors.validation')

            @can('add_idea')
                {!! Form::open([
                    'url' => route('dashboard.idea.store'),
                    'method' => 'post',
                    'id' => 'from',
                    'enctype' => 'multipart/form-data',
                    'onsubmit' => 'if(confirm("Are you sure you want to Submit Your Idea ?")){ return true; } else{ return false; }',
                ]) !!}

                <div class="row">
                    <div class="form-group col-12 col-sm-4 col-md-4 col-lg-4">
                        {!! Form::label('topic', 'Idea Topic', ['class' => 'font-weight-bold custom-form-control-label']) !!}
                        {!! Form::select(
                            'topic',
                            [
                                'Distribution' => 'Distribution',
                                'Consumer Engagement' => 'Consumer Engagement',
                                'B2B' => 'B2B',
                                'Automation' => 'Automation',
                                'Merchandising' => 'Merchandising',
                                'FF' => 'FF',
                                'Research' => 'Research',
                                'Channel Management' => 'Channel Management',
                                'Product' => 'Product',
                                'Pricing and Compliance' => 'Pricing and Compliance',
                                'Sales Management' => 'Sales Management',
                                'Illicit' => 'Illicit',
                                'New Category' => 'New Category',
                                'Alternative Revenue' => 'Alternative Revenue',
                                'Culture and Way of Work' => 'Culture and Way of Work',
                                'Others' => 'Others',
                            ],
                            null,
                            ['class' => 'custom-form-control', 'title' => 'Select Idea Topic', 'required', 'id' => 'topic'],
                        ) !!}
                    </div>
                    <!-- /.form-group col-6 -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6">
                        {!! Form::label('title', 'Idea Title', ['class' => 'font-weight-bold custom-form-control-label']) !!}
                        {!! Form::text('title', null, [
                            'class' => 'form-control custom-form-control',
                            'required',
                            'id' => 'title',
                            'maxlength' => '120',
                        ]) !!}
                        <h6 class="pull-right" id="count_message"></h6>
                    </div>
                    <!-- /.form-group col-12 -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="form-group col-12">
                        {!! Form::label('elevator_pitch', 'Elevator Pitch', ['class' => 'font-weight-bold custom-form-control-label']) !!}
                        {!! Form::textarea('elevator_pitch', null, [
                            'class' => 'form-control custom-form-control custom-form-control-text-area',
                            'rows' => '3',
                            'required',
                            'id' => 'elevator_pitch',
                            'maxword' => '300',
                        ]) !!}
                        <h6 class="pull-right" id="count_textarea"></h6>
                    </div>
                    <!-- /.form-group col-12 -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="form-group col-12">
                        {!! Form::label('description', 'Description', ['class' => 'font-weight-bold custom-form-control-label']) !!}
                        {!! Form::textarea('description', null, [
                            'class' => 'form-control custom-form-control custom-form-control-text-area',
                            'id' => 'description',
                        ]) !!}
                    </div>
                    <!-- /.form-group col-12 -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div style="margin-left:15px">Upload (Document/ Video) Limit left: <span
                            style="color: purple;font-weight:bold" id="uploadLimit"></span></div><br>

                    <div class="col-12">
                        <div class="row" id="uploaded_file">

                        </div>

                    </div><br>
                    <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6">
                        {{-- {!! Form::label('file', 'Upload Files (Document/ Video): ', [
                            'class' => 'font-weight-bold custom-form-control-label',
                        ]) !!}
                        {!! Form::file('file', ['class' => 'form-control-file custom-form-control']) !!}
                        <div class="field_wrapper"> --}}
                        <div>
                            <div class="row" style="display: flex; align-items: center;">
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                    <input type="file" id="upload_form" class="form-control-file custom-form-control"
                                        name="image[]" value="" />
                                    <input type="text" id="uploaded_file_id" hidden
                                        class="form-control-file custom-form-control" name="uploaded_file_id" value="" />
                                    <input type="text" id="idea_id" hidden readonly
                                        class="form-control-file custom-form-control" name="idea_id" value="" />
                                </div>
                                {{-- <div class="col-md-4">
                                    <a href="javascript:void(0);" class="add_button" title="Add field" style="visibility: hidden"><i class="fa fa-plus"></i></a>
                            </div> --}}
                                <div style="background-color: transparent; @if ($agent->isMobile()) margin-top: 15px; margin-left: 15px; width:90%; @else width:200px; @endif"
                                    id="progress-wrp">
                                    <div class="progress-bar"></div>
                                    <div class="status">0%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.form-group col-6 -->
            </div>
            <div class="row pl-3" id="output"></div>
            <!-- /.row -->

            <div class="row">
                <div
                    class="form-group col-12 col-sm-12 col-md-12 col-lg-12 @if (!$agent->isMobile()) text-right @endif">
                    {!! Form::submit('Draft', ['class' => 'btn btn-purple custom-form-control-btn mr-3', 'name' => 'submit_button']) !!}
                    {!! Form::submit('Publish', ['class' => 'btn btn-success custom-form-control-btn', 'name' => 'submit_button']) !!}
                </div>
                <!-- /.form-group col-12 -->
            </div>
            <!-- /.row -->

            {!! Form::close() !!}
        @endcan
    </div>
    <!-- /.col-12 col-sm-12 col-md-12 col lg-12 -->
    {{--
        <div class="col-12 col-sm-10 col-md-9 offset-md-1 col lg-9 offset-lg-1">
            <div class="row" id="uploaded_file">

            </div>

        </div> --}}
    </div>
    <!-- /.row -->

@endsection


@section('customJS')
    @component('layouts.tinymce')
        @slot('editor')
            #description
        @endslot
    @endcomponent


    <script type="text/javascript">
        $(document).ready(function() {
            window.unbeforeunload = null;

            var max = parseInt($("#title").attr("maxlength"));
            $("#count_message").text(0 + "/" + max);
            $("#title").keyup(function(e) {
                let len = $(this).val().length;
                $("#count_message").text(len + "/" + max);
                if ($(this).val().length == max) {}
            });

            var maxTextarea = parseInt($("#elevator_pitch").attr("maxword"));
            $("#count_textarea").text(0 + "/" + maxTextarea);
            $("#elevator_pitch").keyup(function(e) {
                let len = $(this).val().split(' ').length;
                $("#count_textarea").text(len + "/" + maxTextarea);
                if ($(this).val().split(' ').length >= maxTextarea) {
                    // console.log("TCL: maxTextarea", e)

                    let new_val = $(this).val();
                    $("#elevator_pitch").val(new_val.split(' ').slice(0, maxTextarea - 1).join(" ") + " ");


                }



            });


            $("#elevator_pitch").keypress(function(e) {
                let len = $(this).val().split(' ').length;
                $("#count_textarea").text(len + "/" + maxTextarea);
                if ($(this).val().split(' ').length >= maxTextarea - 1) {
                    console.log("TCL: maxTextarea", maxTextarea)
                    e.preventDefault();
                }
            });

            let asset = '<?php echo asset('/idea/files'); ?>'

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
            var max_file_size = 70; //allowed file size 70MB
            var allowed_file_types = ['image/png', 'image/gif', 'image/jpeg', 'image/pjpeg']; //allowed file types
            var result_output = '#output'; //ID of an element for response output
            var my_form_id = '#upload_form'; //ID of an element for response output
            var progress_bar_id = '#progress-wrp'; //ID of an element for response output
            var total_files_allowed = 3; //Number files allowed to upload
            var total_files_size = 0;
            var limitLeft = 0;

            $('#upload_form').on('click', function() {
                $(progress_bar_id + " .progress-bar").css("width", "0%");
                $(progress_bar_id + " .status").text("0%");
            });

            $('#uploadLimit').html(max_file_size + 'MB');
            //on form submit
            $(document).on("change", "#upload_form", function(event) {
                    // console.log($('input[type=file]')[x-1].files[0]);

                    if ($('input[type=file]')[x].files.length) {

                        let fileSize = getFileSize($('input[type=file]')[x].files[0].size);
                        limitLeft = max_file_size - fileSize;
                        let proceed = true; //set proceed flag
                        let error = []; //errors

                        if (limitLeft >= 0) {

                            $('#progress-wrp').css({
                                'visibility': 'visible'
                            });
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
                            $(progress_bar_id + " .progress-bar").css("width", "0%");
                            $(progress_bar_id + " .status").text("0%");

                            if (!window.File && window.FileReader && window.FileList && window
                                .Blob) { //if browser doesn't supports File API
                                error.push(
                                    "Your browser does not support new File API! Please upgrade."
                                ); //push error text
                            } else {
                                //if everything looks good, proceed with jQuery Ajax
                                if (proceed) {

                                    $.ajax({

                                        url: "{{ route('dashboard.file-upload') }}",
                                        type: "POST",
                                        data: formData,
                                        headers: {
                                            'X-CSRF-TOKEN': $("[name=_token]").val()
                                        },
                                        contentType: false,
                                        cache: false,
                                        processData: false,
                                        xhr: function() {
                                            //upload Progress
                                            var xhr = $.ajaxSettings.xhr();
                                            if (xhr.upload) {
                                                xhr.upload.addEventListener('progress', function(
                                                    event) {
                                                    var percent = 0;
                                                    var position = event.loaded || event
                                                        .position;
                                                    var total = event.total;
                                                    if (event.lengthComputable) {
                                                        percent = Math.ceil(position /
                                                            total * 100);
                                                        // console.log(percent);
                                                    }
                                                    //update progressbar
                                                    $(progress_bar_id + " .status").text(
                                                        percent + "%");
                                                    $(progress_bar_id + " .progress-bar")
                                                        .css("width", +(percent * 2) +
                                                            "px");
                                                    // $(progress_bar_id +" .status").css("background-color","#fff");
                                                }, true);
                                            }
                                            return xhr;
                                        },
                                        mimeType: "multipart/form-data"
                                    }).done(function(res) { //

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
                            $('#uploadLimit').html(max_file_size.toFixed(2) + 'MB');
                        } else {
                            error.push("File is larger than limit left:  " + max_file_size.toFixed(2) +
                                " MB, Try smaller file!"); //push error text
                            proceed = false; //set proceed flag to false
                        }

                        $(result_output).html(""); //reset output
                        $(error).each(function(i) { //output any error to output element
                            $(result_output).append('<div class="error" style="color: red">' + error[
                                i] + "</div>");
                        });
                    } else {
                        console.log("Error: File not Found");

                    }
                }

            );



            function uploadedFileShow(upload) {
                let fileData = `<div class="form-group col-12 col-sm-12 col-md-12 col-lg-12">
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

                                        <form method="post" action="{{ route('dashboard.upload-file-delete') }}" id="delete-upload-form-${upload.uuid}">
                                            <input type="text" hidden readonly class="form-control" value="${upload.uuid}" name="upload_id">
                                            @csrf
                                        <form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" onclick="deleteUploadedFile()" class="btn btn-danger delete" id="delete-${upload_id}" form="delete-upload-form-${upload.uuid}">Delete</button>
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

            function getFileSize(fileSize) {
                let sizeInMB;
                var _size = fileSize;
                var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
                    i = 0;
                while (_size > 900) {
                    _size /= 1024;
                    i++;
                }
                var exactSize = (Math.round(_size * 100) / 100);

                if (i == 0) {
                    sizeInMB = (exactSize / 1e+6);
                } else if (i == 1) {
                    sizeInMB = (exactSize / 1000);
                } else if (i == 2) {
                    sizeInMB = exactSize;
                } else {
                    sizeInMB = exactSize * 1000;
                }

                return sizeInMB;
            }
        });
    </script>
@endsection
