{{-- Bootstrap Modal --}}

<div class="container">
    
<!-- Trigger the modal with a button -->
{{-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#likeModal">Open Modal</button> --}}
<!-- Modal -->
<div class="modal fade" id="likeModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content like_modal">
            <div class="modal-header">
                <h4 class="modal-title"> All Likes <span class="badge badge-pill badge-primary">@{{user_likes.length}}</span> </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div v-for="like in user_likes" :key="like.name" class="row like_modal_user_name">
                    {{-- <img src="https://lh3.googleusercontent.com/proxy/tAcmddr83BWyppJCJ8fOzvsCic9gs8zpO8DagCFwUEJTZeoaR5dwg0k8fNrvHJIS6a0YbORcX5F7EiJUMjY5ZH2lylGPltT3zSiyddPmelWinv2jaaHHf2Kg9hfdb7-_klxCwoC7w43OGpM" class="like_user_image" alt="@{{like.name}}" srcset="">  --}}

                    <div class="col-sm-2">
                        <img v-if="like.photo == undefined" class="like_user_image" src="{{asset('/img/profile-picture-placeholder.svg')}}" >
                        <img v-else :src="'{{asset('/')}}' + like.photo" class="like_user_image"  >
                    </div>
                    <div class="col-sm-10">
                        @{{like.name}}
                        <br>
                        <small class="recent-ideas-idea-published-time" style="color: #B9B9B9;">@{{ like.submitted_at | formatDate }}</small>
                    </div>

                    

                    
                </div>
            </div>
            {{-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> --}}
        </div>

    </div>
</div>
</div>