@extends('layouts.admin_template')

@section('title')
    Job Orders | Profile
@endsection
@section('extra_stylesheet')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('/bower_components/select2/dist/css/select2.min.css')}}">
    <link href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css" rel="stylesheet">
@endsection
@section('page_header')
    Job Order Profile
@endsection

@section('main_content')
    <section class="content">

        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <h3 class="profile-username text-center">{{$profile->title}}</h3>

                        <p class="text-muted text-center">{{\App\category::find($profile->category_id)->name}}</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Customer</b> <a class="pull-right">{{ucfirst($profile->customer_name)}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Contact No.</b> <a class="pull-right">{{$profile->customer_contact_number}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Pick-up Date</b> <a class="pull-right">{{$profile->pickup_date}} {{$profile->pickup_time}}</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- About Me Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <strong><i class="fa fa-calendar margin-r-5"></i> Date Created</strong>

                        <p class="text-muted">
                            {{$profile->created_at}}
                        </p>

                        <hr>
                        <strong><i class="fa fa-pencil margin-r-5"></i> Created By</strong>

                        <p class="text-muted">
                            {{\App\User::find($profile->created_by)->username}}
                        </p>

                        <hr>

                        <strong><i class="fa fa-thermometer margin-r-5"></i> Status</strong>

                        <p><small class="label label-warning">{{$profile->status}}</small></p>

                        <hr>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

                        <p>{!! $profile->description !!}</p>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="box">
                    <div class="box-body">
                        <!-- The timeline -->
                        <ul class="timeline timeline-inverse">
                            <!-- timeline time label -->
                            <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
                            </li>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <li>
                                <i class="fa fa-envelope bg-blue"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                                    <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                    <div class="timeline-body">
                                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                        quora plaxo ideeli hulu weebly balihoo...
                                    </div>
                                    <div class="timeline-footer">
                                        <a class="btn btn-primary btn-xs">Read more</a>
                                        <a class="btn btn-danger btn-xs">Delete</a>
                                    </div>
                                </div>
                            </li>
                            <!-- END timeline item -->
                            <!-- timeline item -->
                            <li>
                                <i class="fa fa-user bg-aqua"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                                    <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                                    </h3>
                                </div>
                            </li>
                            <!-- END timeline item -->
                            <!-- timeline item -->
                            <li>
                                <i class="fa fa-comments bg-yellow"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                                    <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                                    tab-content
                                    <div class="timeline-body">
                                        Take me to your leader!
                                        Switzerland is small and neutral!
                                        We are more like Germany, ambitious and misunderstood!
                                    </div>
                                    <div class="timeline-footer">
                                        <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                                    </div>
                                </div>
                            </li>
                            <!-- END timeline item -->
                            <!-- timeline time label -->
                            <li class="time-label">
                        <span class="bg-green">
                          3 Jan. 2014
                        </span>
                            </li>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <li>
                                <i class="fa fa-camera bg-purple"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                                    <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                                    <div class="timeline-body">
                                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                                    </div>
                                </div>
                            </li>
                            <!-- END timeline item -->
                            <li>
                                <i class="fa fa-clock-o bg-gray"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
@endsection

@section('extra_script')
    <!-- DataTables -->
    <script src="{{asset('/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <!-- SlimScroll -->
    <script src="{{asset('/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- FastClick -->
    <script src="{{asset('/bower_components/fastclick/lib/fastclick.js')}}"></script>

    <!-- growl notification -->
    {{--    <script src="{{asset('bower_components/remarkable-bootstrap-notify/bootstrap-notify.min.js')}}"></script>--}}
    <!-- Select2 -->
    <script src="{{asset('/bower_components/select2/dist/js/select2.full.min.js')}}"></script>

    {{--    <script src="{{asset('/js/rolesPermissions.js')}}"></script>--}}

    <script>
        $(function () {
            $('#job-order-list').DataTable()
            $('.role-assign').select2()
        })
    </script>


@endsection