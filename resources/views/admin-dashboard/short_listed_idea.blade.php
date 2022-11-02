@extends('admin-dashboard.layouts.app')

@section('site_title', 'Admin Dashboard')

@section('header_tag')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@2/dist/Chart.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <style>
        @media only screen and (max-width: 600px) {
            .tab_mobile{
                width: 300px;
                height: 200px; 
                overflow: auto;
            }
        }
    </style>
@endsection
@section('bg_image', 'admin-page')
@section('content')
@php $agent = new Jenssegers\Agent\Agent(); @endphp


<div v-if="loading" class="text-center">
    <div class="lds-facebook">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>

<div style="display:none" :style="loading == true ? 'display:none' : 'display:inline'" class="row pt-3 pb-3 pl-4 pr-4 admin-dashboard-right-section">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="container-fluid">
            <div class="row">

                

                <div class="col-sm-8">
                    <span class="h2">Selected  Ideas</span>
                </div>
                <div class="col-sm-4">
                <input style="font-size:22px !important" class="date-own form-control" v-model="yearField" placeholder="Select Year" @input="getIdeaByMonth(monthField)" style="max-width: 200px;" type="number" min="2018" max="{{date('Y')}}">
                </div>
            </div>
            <p>Ideas By month</p>
            <ul class="nav nav-tabs tab_mobile">
                <li class="{{ ( date('m') == 1) ? 'active' : '' }}"><a data-toggle="tab" @click="getIdeaByMonth(1)" href="#home">Jan</a></li>
                <li class="{{ ( date('m') == 2) ? 'active' : '' }}" ><a data-toggle="tab" @click="getIdeaByMonth(2)" href="#menu1">Feb</a></li>
                <li class="{{ ( date('m') == 3) ? 'active' : '' }}"><a data-toggle="tab" @click="getIdeaByMonth(3)" href="#menu2">March</a></li>
                <li class="{{ ( date('m') == 4) ? 'active' : '' }}"><a data-toggle="tab" @click="getIdeaByMonth(4)" href="#menu3">April</a></li>
                <li class="{{ ( date('m') == 5) ? 'active' : '' }}"><a data-toggle="tab" @click="getIdeaByMonth(5)" href="#menu3">May</a></li>
                <li class="{{ ( date('m') == 6) ? 'active' : '' }}"><a data-toggle="tab" @click="getIdeaByMonth(6)" href="#menu3">June</a></li>
                <li class="{{ ( date('m') == 7) ? 'active' : '' }}"><a data-toggle="tab" @click="getIdeaByMonth(7)" href="#menu3">July</a></li>
                <li class="{{ ( date('m') == 8) ? 'active' : '' }}"><a data-toggle="tab" @click="getIdeaByMonth(8)" href="#menu3">Aug</a></li>
                <li class="{{ ( date('m') == 9) ? 'active' : '' }}"><a data-toggle="tab" @click="getIdeaByMonth(9)" href="#menu3">Sept</a></li>
                <li class="{{ ( date('m') == 10) ? 'active' : '' }}"><a data-toggle="tab" @click="getIdeaByMonth(10)" href="#menu3">Oct</a></li>
                <li class="{{ ( date('m') == 11) ? 'active' : '' }}"><a data-toggle="tab" @click="getIdeaByMonth(11)" href="#menu3">Nov</a></li>
                <li class="{{ ( date('m') == 12) ? 'active' : '' }}"><a data-toggle="tab" @click="getIdeaByMonth(12)" href="#menu3">Dec</a></li>
            </ul>
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    
                        <div v-if="ratingSubmitSuccess"  class="alert alert-success alert-dismissible mt-2" role="alert">
                            @{{ ratingSubmitSuccess }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    

                    <p>Now Showing <strong> (  @{{details}} ) </strong> Ideas </p>
                    <table  id="table_id"  class=" display table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Idea Title</th>
                                <th>Written by</th>
                                <th>remove</th>
                            </tr>
                        </thead>
                        <tbody >
                            <tr v-if="!ideas.ideasOfSelectedMonth.length">
                                <td class="text-center h4" colspan="4">No idea found. Select other month/year.</<td>
                            </tr>
                            <tr v-for="(idea, index) in ideas.ideasOfSelectedMonth" :key="index" >
                                {{-- <td>@{{ idea.ideas.id }}</td> --}}
                                <td>@{{ index + 1 }}</td>
                                <td>
                                    <a :href="'/secure/dashboard/idea/' + idea.ideaUUID" target="_blank">
                                        @{{ idea.ideaTitle }}
                                    </a>
                                    
                                </td>
                                <td>
                                    @{{ idea.ideaAuthor }}
                                    <br/>
                                    ( @{{ idea.ideaAuthorDesignation }} )
                                </td>
                                <td> <center><button class="btn btn-danger" @click="unSelectIdea(idea.ideaId)"><span  class="glyphicon glyphicon-minus"></span></button></center> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div v-if="ideas.ideasOfSelectedMonth.length" class="row justify-content-end">
               <button class="btn btn-primary mr-4" @click="sendMailToModerator()" :disabled="(!sendCheck) ? false : true">SEND EMAIL</button> 
               <button class="btn btn-warning mr-4" @click="resendMailToModerator()"  :disabled="(sendCheck) ? false : true" >RESEND EMAIL</button> 
            </div>
        </div>
    </div>
    <!-- /.col-12 col-sm-12 col-md-12 col-lg-12 -->

</div> 
<!-- /.row -->

@endsection

@section('customJS')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script> --}}

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>



<script>
    // $(document).ready( function () {
    //     $('#table_id').DataTable();
    //     $('.dataTables_length').addClass('bs-select');
    // } );

    // $('.date-own').datepicker({
    //     minViewMode: 2,
    //     format: 'yyyy'
    // });

</script>

<script>
Vue.config.devtools = true;

const app = new Vue({
    el: '#app',
    data() {
        return {
            ideas: {ideasOfSelectedMonth:[]},
            yearField: new Date().getFullYear(),
            monthField: new Date().getMonth()+1,
            loading: true,
            ideasCount: 0,
            details : 'Now Showing ( current month ) Ideas',
            monthNames : ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
            ],
            sendCheck: 0,
            ratingSubmitSuccess:"",
        };
    },

    methods:{
        getIdea(month){
            console.log("TCL: getIdea -> month", month)
            console.log("TCL: getIdea -> year", this.yearField)
        },
        getIdeaByMonth(month) {

            this.monthField = month; 

            axios.post('/secure/admin/get-short-listed-idea-by-month', {
                month: month,
                year: this.yearField,
            }).then((response) => {
                this.ideas = response.data;
                this.details = this.monthNames[month-1] + ','+ this.yearField
                this.loading= false;
                this.sendCheck = response.data.sendCheck;
                // this.filteredData = response.data.ideas;
                // this.ideasCount = response.data.ideasCount;
                // this.intervalFetchData();
                // console.log(response.data);
                console.log(response.data);
            }).catch((err) => {
                console.log(err.response);
            });
        },

        unSelectIdea(ideaId){
            // console.log(ideaId);
            axios.post('/secure/admin/delete-from-short-listed-idea', {
                ideaId
            }).then((response) => {
                this.getIdeaByMonth(this.monthField);
                console.log(response.data);
            }).catch((err) => {
                console.log(err.response);
            });
        },
        sendMailToModerator(){
            let constructIdea = [];
            this.ideas.ideasOfSelectedMonth.forEach(element => {
                let tmp={
                    shortlist_id: element.shortListedIdeaId,
                    idea_id: element.ideaId,
                    idea_published_date: element.idea_published_date,
                }
                constructIdea.push(tmp);
            });
            // console.log("TCL: sendMailToModerator -> constructIdea", constructIdea);

            axios.post('/secure/admin/send-idea', {
                ideas: constructIdea,
            }).then(res => {
                this.ratingSubmitSuccess = res.data.success;
                console.log(res);
                })
                .catch(err => console.log(err));
        },
        resendMailToModerator(){
            // console.log("resend mail method")
            let constructIdea = [];
            this.ideas.ideasOfSelectedMonth.forEach(element => {
                let tmp={
                    shortlist_id: element.shortListedIdeaId,
                    idea_id: element.ideaId,
                    idea_published_date: element.idea_published_date,
                }
                constructIdea.push(tmp);
            });
            console.log("TCL: sendMailToModerator -> constructIdea", constructIdea);

            axios.post('/secure/admin/resend-idea', {
                ideas: constructIdea,
            }).then(res => {
                this.ratingSubmitSuccess = res.data.success;
                console.log("TCL: resendMailToModerator -> res.success", res.data.success)
                console.log(res.data)
                })
                .catch(err => console.log(err));
        }
    },
    <!-- method end -->


    created() {
        this.getIdeaByMonth(this.monthField);
        console.log("TCL: created -> getIdea", this.yearField,this.monthField);

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
