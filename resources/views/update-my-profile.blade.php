@extends('layouts.app')

@section('site_title', 'Update My Profile')

@section('header_tag')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/croppie@2/croppie.min.css">

    <style type="text/css">
        .file-upload {
            display: none;
        }

        .upload-button {
            font-size: 1.2em;
        }

        .upload-button:hover {
            transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
            color: #999;
        }

        .image_container {
            position: relative;
        }

        .middle {
            position: absolute;
            transition: .5s ease;
            opacity: 0;
            top: 47%;
            left: 0;
            width: 120px;
            text-align: center;
        }

        .imgbtn_text {
            background: black;
            color: white;
            font-size: 16px;
            padding: 16px 32px;
            border-bottom-left-radius: 200px;
            border-bottom-right-radius: 200px;
        }

        .image {
            opacity: 1;
            display: block;
            transition: .5s ease;
            backface-visibility: hidden;
        }

        .image_container:hover .middle {
            opacity: 0.5;

        }
    </style>
@endsection

@section('bg_image', 'profile-page full-height')

@section('content')
    @php $agent = new Jenssegers\Agent\Agent(); @endphp

    <div class="row py-3">
        <div class="col-12 col-sm-10 col-md-6 offset-md-1 col-lg-6 offset-lg-1 p-5"
            style="-webkit-box-shadow:0 0 10px 2px rgba(0,62,145,0.15);-moz-box-shadow:0 0 10px 2px rgba(0,62,145,0.15);box-shadow:0 0 10px 2px rgba(0,62,145,0.15);">
            {!! laraflash()->render() !!}

            @include('errors.validation')

            {!! Form::open([
                'route' => 'dashboard.update-my-profile-form',
                'method' => 'POST',
                'files' => 'true',
                'id' => 'form',
            ]) !!}

            <div class="mb-4">
                <div class="image_container">

                    @if (count($image) > 0 && $image[0]->profile_picture != '')
                        <img class="image rounded-circle" id="profile-pic" src="{{ url($image[0]->profile_picture) }}"
                            width="120" height="120" alt="">
                    @else
                        <img class="image rounded-circle" id="profile-pic"
                            src="{{ asset('img/profile-picture-placeholder.svg') }}" width="120" height="120"
                            alt="">
                    @endif

                    <div class="middle">
                        <div class="imgbtn_text">
                            <img src="{{ asset('img/photo-camera.svg') }}" class="upload-button" height="30"
                                alt="">
                            <button style="display: none;" type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#exampleModalLong"></button>
                            <input class="file-upload" type="file" accept="image/*" />
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title">Adjust Profile Picture Before Update</div>
                            <!-- /.modal-title -->

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="upload-demo"></div>
                            <input type="hidden" id="imagebase64" name="profile_picture">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary upload-result">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.mb-4 -->

            <div class="row">
                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                    {!! Form::label('cell_number') !!}
                    {!! Form::text('cell_number', auth()->user()->cell_number, ['class' => 'form-control cell-number']) !!}
                </div>
                <!-- /.form-group col-4 -->

                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                    {!! Form::label('designation') !!}
                    {!! Form::text('designation', auth()->user()->designation, ['class' => 'form-control']) !!}
                </div>
                <!-- /.form-group col-4 -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                    {!! Form::label('team') !!}
                    {!! Form::select(
                        'team',
                        [
                            'Dhaka Region' => 'Dhaka Region',
                            'Chittagong Region' => 'Chittagong Region',
                            'Khulna Region' => 'Khulna Region',
                            'Sylhet Region' => 'Sylhet Region',
                            'Rajshahi Region' => 'Rajshahi Region',
                            'Activation' => 'Activation',
                            'Business Development' => 'Business Development',
                            'Brands' => 'Brands',
                            'SP&I' => 'SP&I',
                            'Marketing Finance' => 'Marketing Finance',
                            'Marketing HR' => 'Marketing HR',
                            'MSD' => 'MSD',
                        ],
                        auth()->user()->team,
                        ['title' => 'Select Team', 'required'],
                    ) !!}
                </div>
                <!-- /.form-group col-4 -->

            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                    <hr class="hr">
                    <!-- /.hr -->
                    <strong class="text-deep-purple">Change Password</strong>
                    <!-- /.text-deep-purple -->
                </div>
                <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 mb-3 -->

                <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6">
                    {!! Form::label('password') !!}
                    {!! Form::password('password', [
                        'class' => 'form-control',
                        'data-parsley-minlength' => '8',
                        'data-parsley-uppercase' => '1',
                        'data-parsley-lowercase' => '1',
                        'data-parsley-number' => '1',
                        'data-parsley-special' => '1',
                    ]) !!}
                </div>
                <!-- /.form-group col-4 -->

                <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6">
                    {!! Form::label('password_confirmation') !!}
                    {!! Form::password('password_confirmation', [
                        'class' => 'form-control',
                        'data-parsley-equalto' => '#password',
                        'data-parsley-minlength' => '8',
                    ]) !!}
                </div>
                <!-- /.form-group col-4 -->
            </div>
            <!-- /.row -->

            {!! Form::submit('Update My Profile', ['class' => 'btn btn-purple', 'form' => 'form']) !!}

            <a href="{{ route('dashboard.my-profile') }}"
                class="btn btn-primary @if (!$agent->isMobile()) ml-3 @else mt-3 @endif">Back to My Profile</a>
            <!-- /.btn btn-primary -->

            {!! Form::close() !!}
        </div>
        <!-- /.col-12 col-sm-10 col-md-7 col-lg-7 -->
    </div>
    <!-- /.row -->
@endsection

@section('customJS')
    <script src="https://cdn.jsdelivr.net/npm/croppie@2/croppie.min.js"></script>
    <script type="text/javascript">
        let $uploadCrop;

        function readFile(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $uploadCrop.croppie('bind', {
                        url: e.target.result,

                        // Croppie automatically tries to center the image when you bind to it
                        // points: [77, 469, 280, 739],
                    });

                    //alert(e.target.result);
                    $('.upload-demo').addClass('ready');
                };
                reader.readAsDataURL(input.files[0]);
            }

        }

        $uploadCrop = $('#upload-demo').croppie({
            viewport: {
                width: 300,
                height: 300,
                type: 'square',
            },
            boundary: {
                width: 500,
                height: 500,
            },
            showZoomer: true,
            enforceBoundary: true,
        });

        $('.file-upload').on('change', function() {
            readFile(this);
        });

        $('.upload-result').on('click', function(ev) {

            $uploadCrop.croppie('result', {
                type: 'base64',
                size: 'viewport',
            }).then(function(resp) {
                b64 = resp.replace(/^data:image.+;base64,/, '');
                $('#imagebase64').val(b64);
                $('#form').submit();

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            const readURL = function(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $('#profile-pic').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            };

            $('.file-upload').on('change', function() {
                readURL(this);
                $('#exampleModal').modal('show');

                // Slider Min Max Set
                $('.cr-slider').attr({
                    'max': 1.5,
                    'min': 0.2,
                    'aria-valuenow': 1,
                });

            });

            $('.upload-button').on('click', function() {
                $('.file-upload').click();
            });
        });
    </script>
@endsection
