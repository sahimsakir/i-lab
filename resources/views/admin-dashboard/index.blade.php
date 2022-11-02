@extends('admin-dashboard.layouts.app')

@section('site_title', 'Admin Dashboard')

@section('header_tag')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@2/dist/Chart.min.css">
  <style>
    .enable-ideas-scrollable {
      max-height: 33vh !important;
    }
  </style>
@endsection

@section('bg_image', 'admin-page full-height')

@section('content')
  @php $agent = new Jenssegers\Agent\Agent(); @endphp

  <div class="row pt-3 pb-3 pl-4 pr-4 admin-dashboard-right-section">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
      <div class="row @if ($agent->isMobile()) mb-2 @else mb-3 @endif">
        <div class="col-12 col-sm-8 col-md-8 col-lg-8 @if ($agent->isMobile()) mb-4 @endif">
          <div class="card admin-card-shadow p-3">
            <h6 class="text-uppercase mb-0 font-weight-bold" style="color: #00B6F5;">Idea Received Ratio</h6>
            <!-- /.text-muted text-uppercase -->

            <hr class="hr" style="border: 1px solid #EDEDED;">
            <!-- /.hr -->

            <div class="row">
              <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                {!! $ideasChart->container() !!}
              </div>
              <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card card-shadow p-3 -->
        </div>
        <!-- /.col-12 col-sm-9 col-md-9 col-lg-9 -->

        <div class="col-12 col-sm-4 col-md-4 col-lg-4">
          <div class="card admin-card-shadow p-3">
            <h6 class="text-uppercase mb-0 font-weight-bold" style="color: #00B6F5;">Total Idea</h6>
            <!-- /.text-muted text-uppercase -->

            <hr class="hr" style="border: 1px solid #EDEDED;">
            <!-- /.hr -->

            <div class="row">
              <div class="col-6 col-sm-6 col-md-6 col-lg-6 text-center">
                <div class="admin-dashboard-idea-badge-blue">
                  <span class="admin-dashboard-idea-badge-blue-content">@{{featuredIdeasCount}}  </span>
                  <!-- /.draft-card -->
                </div>

                <p class="mb-0" style="color: #6F6F6F; font-size: 13px; font-weight: 600;">Featured Ideas</p>
                <!-- /.mb-0 -->
              </div>
              <!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->

              <div class="col-6 col-sm-6 col-md-6 col-lg-6 text-center">
                <div class="admin-dashboard-idea-badge-light-blue">
                  <span class="admin-dashboard-idea-badge-light-blue-content"> @{{submittedIdeasCount}} </span>
                  <!-- /.draft-card -->
                </div>

                <p class="mb-0" style="color: #6F6F6F; font-size: 13px; font-weight: 600;">No. of Idea submitted</p>
                <!-- /.mb-0 -->
              </div>
              <!-- /.col-6 col-sm-6 col-md-6 col-lg-6 -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card card-shadow p-3 -->
        </div>
        <!-- /.col-12 col-sm-3 col-md-3 col-lg-3 -->
      </div>
      <!-- /.row mb-4 -->
      
    
    </div>

  </div>
  <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->
  </div>
  <!-- /.row -->
@endsection

@section('customJS')
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2/dist/Chart.min.js"></script>

  {!! $ideasChart->script() !!}

  <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>

  <script>
    Vue.config.devtools = true;

    const app = new Vue({
      el: '#app',
      data() {
        return {
          ideas: [],
          featuredIdeasCount: "<?php echo $featuredIdeasCount;?>",
          submittedIdeasCount: "<?php echo $submittedIdeasCount;?>",
          loading: true
        };
      },

      methods: {
        getIdea() {

          axios.get('/secure/dashboard/recent-idea-published').then((response) => {
            this.ideas = response.data.ideas;
            // console.log(response.data);
            this.loading = false;
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
        makeFeatured(ideaId) {
          // alert(ideaId);
          axios.post(`/secure/admin/make_featured`, { idea_id: ideaId }).then((response) => {
            this.featuredIdeasCount++;
            this.getIdea();

            console.log(response.data);
          }).catch((err) => {
            console.log(err);
          });
        },
        makeNonFeatur(ideaId) {
          // alert(ideaId);
          axios.post(`/secure/admin/make_non_featured`, { idea_id: ideaId }).then((response) => {
            this.featuredIdeasCount--;
            this.getIdea();

            console.log(response.data);
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
