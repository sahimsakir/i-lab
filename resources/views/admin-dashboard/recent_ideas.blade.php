@extends('admin-dashboard.layouts.app')

@section('site_title', 'Admin Dashboard')

@section('header_tag')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@2/dist/Chart.min.css">
  
@endsection

@section('bg_image', 'admin-page')


@section('content')
  @php $agent = new Jenssegers\Agent\Agent(); @endphp

  


  <div class="row pt-3 pb-3 pl-4 pr-4 admin-dashboard-right-section">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">


      <div class="row">
        <div class="col-12 col-12 col-md-12 col-lg-12">
          <div class="card card-shadow p-3">
            <h5 class="text-deep-purple mb-0">
                {{$idea_name}} &nbsp;&nbsp;&nbsp;<span class="badge badge-purple badge-pill">{{ $ideasCount }}
            </span>
            <div>

              <hr>
              <div style="float:left;font-size: small;">
              
                <p v-if="dateField == ''">
                  Now Showing ( {{date('M-Y')}} )Data 
                </p>
                <p  v-else>
                  Now Showing 
                  (
                     @{{moment(String(dateField[0])).format('D/M/Y')}} -
                     @{{moment(String(dateField[1])).format('D/M/Y')}} 
                  )
                  Data 
                  <span class="badge badge-purple badge-pill">
                    @{{ ideasCount }}
                  </span> 
                </p>
                
              </div>


                <input type="text" autocomplete="off" name="date" id="demo-1" v-model="dateField" @focus="CallDatePicker()" class="form-control custom-form-control date_picker" placeholder="Date">
            </div>
            </h5>
            <hr class="hr">

            <div>
              <div v-if="loading" class="text-center">
                <div class="lds-facebook">
                  <div></div>
                  <div></div>
                  <div></div>
                </div>
              </div>

              <div style="display:none" :style="loading == true ? 'display:none' : 'display:inline'">
                <div class="enable-ideas-scrollable">
                  <ul class="list-unstyled recent-ideas-module pt-0 pb-1" v-for="(idea, index) in ideas" :key="index">
                    <div class="row">
                      <div class="col-12 col-sm-8 col-md-8 col-lg-8">
                        <li class="media hr pb-0 mb-2 mt-2">

                          <div v-if="idea.user.profile_picture == undefined">
                            <a :href="'/secure/dashboard/idea/' + idea.uuid" target="_blank"><img src="/img/profile-picture-placeholder.svg"
                                                                                                  class="mr-2 rounded-circle" alt="Profile Picture" height="60"></a>
                          </div>

                          <div v-else>
                            <a :href="'/secure/dashboard/idea/' + idea.uuid" target="_blank"><img :src="'{{asset('/')}}' + idea.user.profile_picture"
                                                                                                  class="mr-2 rounded-circle" alt="Profile Picture" height="60"></a>
                          </div>

                          <div class="media-body recent-ideas-idea-description">
                            <h5 class="recent-ideas-idea-title" style="color: #FFAD4D;">
                              <a :href="'/secure/dashboard/idea/' + idea.uuid" target="_blank">@{{ idea.title }}<span class="text-muted">|</span> @{{ idea.topic
                                }}</a>
                            </h5>

                            <div class="row">
                              <div class="col-12 col-sm-8 col-md-8 col-lg-8">
                                <p class="mb-1 font-weight-bold recent-ideas-idea-author" style="color: #555555;">@{{ idea.user.first_name }}, @{{
                                  idea.user.designation }}</p>
                              </div>
                              <!-- /.col-12 col-sm-8 col-md-8 col-lg-8 -->

                              @if (!$agent->isMobile())
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 text-right">
                                  <span v-if="idea.is_featured == 1"><span class="is-featured"><img src="{{ asset('img/featured.svg') }}" alt=""></span></span>
                                  <small class="recent-ideas-idea-published-time" style="color: #B9B9B9;">@{{ idea.submitted_at | formatDate }}</small>
                                </div>
                                <!-- /.col-12 col-sm-4 col-md-4 col-lg-4 -->
                              @endif
                            </div>
                            <!-- /.row -->

                            <p style="color: #414141;">@{{ idea.elevator_pitch | truncate(300, '...') }}</p>

                            {{--<div class="text-right"><a href="#" class="view-more-button">View More</a></div>
                            <!-- /.text-right -->--}}

                            <div class="row" style="display: flex; font-size: 11px;">
                              <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                <div>
                                  <span class="mr-2" style="color: #7B7B7B;">@{{ idea.comments.length }}</span> comments
                                  {{-- <img src="{{ asset('img/chat.svg') }}" height="18" alt="" class="ml-2"> --}}
                                  <span class="ml-3 mr-2" style="color: #7B7B7B;">@{{idea.likes.length}} likes</span>
                                  {{-- <img @click="like(idea.id)" src="{{ asset('img/like.svg') }}" height="16" alt=""> --}}
                                </div>
                              </div>
                              <!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->

                              <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-right">


                                  <a :href="'/secure/dashboard/idea/' + idea.uuid" target="_blank" class="view-more-button " style="font-size: 11px;">Full
                                    View</a>
                                </div>
                                <!-- /.text-right -->
                              </div>
                              <!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->
                            </div>
                            <!-- /.row -->
                          </div>
                        </li>
                      </div>
                      <!-- /.col-12 col-12 col-md-12 col-lg-12 -->

                      <div class="col-12 col-sm-4 col-md-4 col-lg-4 feature_column">
                        <div class="row">
                          <div class="col-12 col-sm-6 @if ($agent->isMobile()) text-center @endif"
                               @if (!$agent->isMobile()) style="display: flex;" @endif>
                            @if (!$agent->isMobile())
                              <a v-if="!idea.short_listed_idea" @click="makeShortlist(idea.id)" class="view-more-button make_shortlist_idea_badge"
                                 style="font-size: 11px;">Make Short-List</a>
                              <span v-else @click="makeNonShortlist(idea.id)" class="shortlist_idea_badge" style="font-size: 11px;">Short-Listed</span>
                            @else
                              <a 
                                v-if="!idea.short_listed_idea"
                                @click="makeShortlist(idea.id)"
                                class="view-more-button make_shortlist_idea_badge"
                                style="font-size: 11px;">
                                Make Short-List
                              </a>
                              <span v-else @click="makeNonShortlist(idea.id)" class="shortlist_idea_badge" style="font-size: 11px;">Short-Listed</span>

                              <div class="col-12 mt-2">
                                <small class="recent-ideas-idea-published-time" style="color: #B9B9B9;">@{{ idea.submitted_at | formatDate }}</small>
                              </div>
                            @endif
                          </div>

                          <div class="col-12 col-sm-6 @if ($agent->isMobile()) text-center @endif"
                               @if (!$agent->isMobile()) style="display: flex;" @endif>
                            @if (!$agent->isMobile())
                              <a v-if="idea.is_featured == 0" @click="makeFeatured(idea.id)" class="view-more-button make_featured_idea_badge"
                                 style="font-size: 11px;">Make Fetured</a>
                              <span v-else @click="makeNonFeatur(idea.id)" class="featured_idea_badge" style="font-size: 11px;">Fetured</span>
                            @else
                              <a v-if="idea.is_featured == 0" @click="makeFeatured(idea.id)" class="view-more-button make_featured_idea_badge"
                                 style="font-size: 11px;">Make Fetured</a>
                              <span v-else @click="makeNonFeatur(idea.id)" class="featured_idea_badge" style="font-size: 11px;">Fetured</span>

                              <span v-if="idea.is_featured == 1" class="mr-2"><span><img src="{{ asset('img/featured.svg') }}" alt=""></span></span>

                              <div class="col-12 mt-2">
                                <small class="recent-ideas-idea-published-time" style="color: #B9B9B9;">@{{ idea.submitted_at | formatDate }}</small>
                              </div>
                            @endif
                          </div>
                        </div>

                      </div>
                      <!-- /.col-12 col-12 col-md-12 col-lg-12 -->
                    </div>


                  </ul>
                </div>
              </div>
            </div>
            <!-- /.enable-ideas-scrollable -->

          </div>
          <!-- /.card card-shadow -->
        </div>
        <!-- /.col-12 col-12 col-md-12 col-lg-12 -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
  </div>
  <!-- /.row -->

  </div>

@endsection

@section('customJS')



  <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>

  <script>
    Vue.config.devtools = true;

    const app = new Vue({
      el: '#app',
      data() {
        return {
          ideas: [],
          dateField: [],
          loading: true,
          ideasCount: 0
        };
      },

      methods: {
        getIdea() {

          axios.get('/secure/dashboard/recent-ideas-published').then((response) => {
            this.ideas = response.data.ideas;
            this.loading = false;
            // console.log(response.data);
          }).catch((err) => {
            console.log(err.response);
          });
        },


        like(ideaId) {
        axios.post(`/secure/dashboard/submit-like`, { idea_id: ideaId }).then((response) => {
            this.getIdea();

            console.log(response.data);
        }).catch((err) => {
            console.log(err);
        });
        },



// Stert- Filter Functions
        CallDatePicker(){
            let myThis = this;
            var picker = new Lightpick({
            field: document.getElementById('demo-1'),
            singleDate: false,
            autoClose: true,
            selectForward: false,
            format: 'MM/DD/YYYY',
            // minDate: moment().startOf('month').add(7, 'day'),
            // maxDate: moment().endOf('month').subtract(7, 'day'),
            onSelect: function(start, end){
                date = document.getElementById('demo-1').value;
                this.dateField = date.split("-");
                console.log(this.dateField[1])
                if (this.dateField[1] != " ...") {
                    myThis.filterAllIdea(this.dateField);
                }
            }
            });
        },
        filterAllIdea(datePickerData=null){

            if(this.dateField != datePickerData){
                this.dateField = datePickerData;
            }

            // console.log("called", this.nameField);
            const data = {};

            if (this.dateField.length == 2 && this.topic != '' && this.nameField != '') {
                data.start = this.dateField[0];
                data.end = this.dateField[1];
                data.topic = this.topicField;
                data.uuid = this.nameField;
            }//3select
            else if (this.dateField.length == 2 && this.topic == '' && this.nameField != '') {
                data.start = this.dateField[0];
                data.end = this.dateField[1];
                data.topic = null;
                data.uuid = this.nameField;
            }//date&name
            else if (this.dateField.length == 2 && this.topic != '' && this.nameField == '') {
                data.start = this.dateField[0];
                data.end = this.dateField[1];
                data.topic = this.topicField;
                data.uuid = null;
            }//date&topic
            else if (this.dateField.length != 2 && this.topic != '' && this.nameField != '') {
                data.start = null;
                data.end = null;
                data.topic = this.topicField;
                data.uuid = this.nameField;
            }//topic&name
            else if (this.dateField.length == 2 && this.topic == '' && this.nameField == '') {
                data.start = this.dateField[0];
                data.end = this.dateField[1];
                data.topic = null;
                data.uuid = null;
            }//only date
            else if (this.dateField.length != 2 && this.topic != '' && this.nameField == '') {
                data.start = null;
                data.end = null;
                data.topic = this.topicField;
                data.uuid = null;
            }//only topic
            else {
                data.start = null;
                data.end = null;
                data.topic = null;
                data.uuid = this.nameField;
            }//only name

            // if (this.dateField.length == 2 && this.topic != '') {

            //     data.start = this.dateField[0];
            //     data.end = this.dateField[1];
            //     data.topic = this.topicField;

            // } else if (this.dateField.length == 2 && this.topic == '') {

            //     data.start = this.dateField[0];
            //     data.end = this.dateField[1];
            //     data.topic = null;

            // } else {
            //     data.start = null;
            //     data.end = null;
            //     data.topic = this.topicField;
            // }

            console.log(data);
            axios.post('/secure/dashboard/filter-all-ideas-published', {
                start: data.start,
                end: data.end,
                topic: data.topic,
                uuid: data.uuid
            }).then((response) => {
                this.ideas = response.data.ideas;
                this.filteredData = response.data.ideas;
                this.ideasCount = response.data.ideasCount;
                this.intervalFetchData();

                // console.log(data);
                // console.log(response.data);
            }).catch((err) => {
                console.log(err.response);
            });
        },
// End-Filter Functions



        makeFeatured(ideaId) {
          // alert(ideaId);
          axios.post(`/secure/admin/make_featured`, {
                idea_id: ideaId ,
                
            }).then((response) => {
            if(this.dateField == ""){
              console.log("empty");
               this.getIdea();

            }else{
              this.filterAllIdea(this.dateField);
            }

            console.log(response.data);
          }).catch((err) => {
            console.log(err);
          });
        },
        makeNonFeatur(ideaId) {
          // alert(ideaId);
          axios.post(`/secure/admin/make_non_featured`, {
                idea_id: ideaId,
                
            }).then((response) => {
            if(this.dateField == ""){
              console.log("empty");
               this.getIdea();
            }else{
              this.filterAllIdea(this.dateField);
            }

            console.log(response.data);
          }).catch((err) => {
            console.log(err);
          });
        },
        makeShortlist(ideaId) {
          // alert(ideaId);
          axios.post(`/secure/admin/make_shortlist`, {
                idea_id: ideaId ,
                
            }).then((response) => {
            if(this.dateField == ""){
               this.getIdea();

            }else{
              this.filterAllIdea(this.dateField);
            }
          }).catch((err) => {
            console.log(err);
          });
        },
        makeNonShortlist(ideaId) {
          // alert(ideaId);
          axios.post(`/secure/admin/make_non_shortlist`, {
                idea_id: ideaId,
                
            }).then((response) => {
            if(this.dateField == ""){
               this.getIdea();
            }else{
              this.filterAllIdea(this.dateField);
            }
          }).catch((err) => {
            console.log(err);
          });
        }
      },
      created() {
        this.getIdea();

        Echo.channel('idea').listen('NewComment', (e) => {
          this.comments.push({
            comment: e.comment
          });
        });
      }
    });

    Vue.filter('formatDate', function(value) {
      if (value) {
        return moment(String(value)).fromNow();
      }
    });

    const filter = function(text, length, clamp) {
      clamp = clamp || '...';
      var node = document.createElement('div');
      node.innerHTML = text;
      var content = node.textContent;
      return content.length > length ? content.slice(0, length) + clamp : content;
    };

    Vue.filter('truncate', filter);

    // window.__VUE_DEVTOOLS_GLOBAL_HOOK__.Vue = app.constructor;
  </script>
@endsection
