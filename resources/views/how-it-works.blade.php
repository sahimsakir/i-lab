@extends('layouts.app')

@section('site_title', 'How It Works')

@section('bg_image', 'how-it-works-page full-height')

@section('content')
    <div class="row mb-3">
        <div class="col-12 col-sm-12 col-md-10 col-lg-10">
            <div class="how-it-works-page mb-4">
                <h5 class="text-uppercase font-weight-bold mb-4" style="color: #432BC4;">WHAT IS ILAB?</h5>

                <p>Innovations are transforming industries globally. From technology to FMCG, be it with product or
                    service, new ideas are shaping the global trends. Ideas born in small cubicles are becoming big
                    and mainstream in no time. Processes, practices or promotion, ideas are contributing directly to
                    the strategic agenda of an organization, to the bigger picture. Ideas can give a business the
                    edge to rise above others.Creating right environment for idea incubation has become necessity
                    for any business. Because ideas can make work simpler, response faster and the organization
                    stronger.</p>

                <p>With that in mind, iLab has been created to act as the launchpad for the unique and fascinating
                    ideas cooking in your head. If you have an idea, if you want to challenge the status quo, if you
                    want to bring your difference – post your ideas in iLab.</p>

                <p>Its time to put on the thinking hat, its time to give your ideas wings!</p>

            </div>
            <!-- /.how-it-works-page mb-4 -->

            <h5 class="text-uppercase font-weight-bold mb-4" style="color: #432BC4;">It’s Easy to submit an idea</h5>

            <div class="mb-3">
                <img src="{{ asset('img/idea-submission-steps.svg') }}" alt="" class="img-fluid">
                <!-- /.img-fluid -->
            </div>
            <!-- /.mb-4 -->

            <div class="row">
                <div class="col-12 col-sm-12 col-md-7 col-lg-7">
                    <div class="idea-submission-steps mb-1">
                        <h5 style="color: #607D8C">Step 1</h5>
                        <p>Login to the website and select a topic. </p>
                    </div>
                    <!-- /.idea-submission-steps mb-1 -->

                    <div class="idea-submission-steps mb-1">
                        <h5 style="color: #9982FD">Step 2</h5>
                        <p>Write your idea in your own words. Attach supporting documents if you have (e.g. PPT file, images etc.)</p>
                    </div>
                    <!-- /.idea-submission-steps mb-1 -->

                    <div class="idea-submission-steps mb-1">
                        <h5 style="color: #00BAD6">Step 3</h5>
                        <p>Submit your idea or save it as ‘Draft’. You can always edit the drafts anytime you want. Drafts can be submitted later.</p>
                    </div>
                    <!-- /.idea-submission-steps mb-1 -->
                </div>
                <!-- /.col-12 col-sm-12 col-md-8 col-lg-8 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
    </div>
    <!-- /.row mb-3 -->
@endsection
