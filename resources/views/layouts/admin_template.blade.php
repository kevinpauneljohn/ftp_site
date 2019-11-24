@php
use App\User;

/**
will count the total pending task
* @var $taskCount
*/
$taskCount = User::find(auth()->user()->id)->tasks()->where('status','pending');
$pendingTask = $taskCount->get();
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/bower_components/admin-lte/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect. -->
    <link rel="stylesheet" href="{{ asset('/bower_components/admin-lte/dist/css/skins/skin-purple.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/design.css') }}">

@yield('extra_stylesheet')

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style type="text/css">
        .invalid-feedback{
            color:red;
            font-size:12px;
        }
        .required{
            color:Red;
        }
    </style>
</head>
<body class="hold-transition skin-purple sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>F2</b>P</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>File2</b>PRINT</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            @if($taskCount->count() > 0)
                                <span class="label label-danger">{{$taskCount->count()}}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have {{$taskCount->count()}} Pending tasks</li>
                            @foreach($pendingTask as $task)
                                <li>
                                    <!-- /.menu -->
                                    <!-- inner menu: contains the messages -->
                                    <ul class="menu">
                                        <li><!-- start message -->
                                            <a href="{{route('task.profile',['taskId' => $task->id])}}">
                                                <div class="pull-left">
                                                    <!-- User Image -->
                                                    <img src="{{ asset('/bower_components/admin-lte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                                                </div>
                                                <!-- Message title and timestamp -->
                                                <h4>
                                                    Job Order: <strong title="{{\App\JobOrder::find($task->job_order_id)->title}}">{{str_pad($task->job_order_id, 5, '0', STR_PAD_LEFT)}}</strong>
                                                    <small><i class="fa fa-clock-o"></i> {{$diff = Carbon\Carbon::parse($task->created_at)->diffForHumans()}}</small>
                                                </h4>
                                                <!-- The message -->
                                                <p>{{$task->title}}</p>
                                            </a>
                                        </li>
                                        <!-- end message -->
                                    </ul>
                                </li>
                                @endforeach
                            <li class="footer"><a href="{{route('task.mine')}}">View all tasks</a></li>
                        </ul>
                    </li>
                    <!-- /.messages-menu -->

                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{ asset('/bower_components/admin-lte/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{ asset('/bower_components/admin-lte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">

                                <p>
                                    {{ucfirst(Auth::user()->username)}}
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">

                                    <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ asset('/bower_components/admin-lte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ucfirst(Auth::user()->username)}}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>
                <!-- Optionally, you can add icons to the links -->
                <li><a href="{{route('customer.index')}}"><i class="fa fa-home"></i> <span>Visit Site</span></a></li>
                <li{{(Request::segment(1) == 'dashboard') ? ' class=active' : ''}}><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                @role('super admin')
                    <li{{(Request::segment(1) == 'users') ? ' class=active' : ''}}><a href="{{url('/users')}}"><i class="fa fa-users"></i> <span>Users</span></a></li>
                <li class="{{(Request::segment(1) == 'roles') ? 'active ' : ' '}}treeview">
                    <a href="#">
                        <i class="fa fa-sitemap"></i><span>Roles and Permission</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                        <ul class="treeview-menu">
                            <li{{(Request::segment(2) == 'roles') ? ' class=active' : ''}}><a href="{{url('/roles/roles')}}">Roles</a></li>
                            <li{{(Request::segment(2) == 'permissions') ? ' class=active' : ''}}><a href="{{url('/roles/permissions')}}">Permissions</a></li>
                        </ul>
                    </a>
                </li>
                @endrole

                @hasanyrole('super admin|admin')
                <li class="{{(Request::segment(1) == 'product') ? 'active ' : ' '}}treeview">
                    <a href="#">
                        <i class="fa fa-shopping-bag"></i><span>Product</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                        <ul class="treeview-menu">
                            <li{{(Request::segment(2) == 'products') ? ' class=active' : ''}}><a href="{{url('/product/products')}}">Products</a></li>
                            <li{{(Request::segment(2) == 'add-product') ? ' class=active' : ''}}><a href="{{url('/product/add-product')}}">Add Product</a></li>
                            <li{{(Request::segment(2) == 'category') ? ' class=active' : ''}}><a href="{{route('category')}}">Category</a></li>
                        </ul>
                    </a>
                </li>
                @endhasanyrole

                @hasanyrole('super admin|admin|graphic artist')
                <li class="{{(Request::segment(1) == 'job-order') ? 'active ' : ' '}}treeview">
                    <a href="#">
                        <i class="fa fa-tasks"></i><span>Job Orders</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                        <ul class="treeview-menu">
                            <li{{(Request::segment(2) == 'orders') ? ' class=active' : ''}}><a href="{{route('job.orders')}}">Orders</a></li>
                            @can('view job orders')
                            <li{{(Request::segment(2) == 'add-job-order') ? ' class=active' : ''}}><a href="{{route('job.orders.add')}}">Add Orders</a></li>
                                @endcan
                        </ul>
                    </a>
                </li>
                @endhasanyrole

                @hasanyrole('super admin|admin|graphic artist|reseller|sales')
                <li class="{{(Request::segment(1) == 'task') ? 'active ' : ' '}}treeview">
                    <a href="#">
                        <i class="fa fa-tasks"></i><span>Task</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                        <ul class="treeview-menu">
                            @can('view all tasks')
                            <li{{(Request::segment(2) == 'all-task') ? ' class=active' : ''}}><a href="{{route('task.all')}}">All Tasks</a></li>
                            @endcan
                            <li{{(Request::segment(2) == 'my-task') ? ' class=active' : ''}}><a href="{{route('task.mine')}}">My Tasks</a></li>
                        </ul>
                    </a>
                </li>
                @endhasanyrole
                @hasanyrole('super admin|admin')
                <li class="{{(Request::segment(1) == 'activity') ? 'active ' : ' '}}treeview">
                    <a href="#">
                        <i class="fa fa-history"></i><span>Activity</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                        <ul class="treeview-menu">
                            <li{{(Request::segment(2) == 'my-task') ? ' class=active' : ''}}><a href="{{route('task.mine')}}">View Activity</a></li>
                        </ul>
                    </a>
                </li>
                @endhasanyrole
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('page_header')

            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            @section('main_content')

            @show

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2019 <a href="#">OuterboxPRO</a>.</strong> All rights reserved.
    </footer>

    <!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="{{ asset('/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/bower_components/admin-lte/dist/js/adminlte.min.js') }}"></script>
<script src="{{asset('/js/notify.min.js')}}"></script>
<script src="https://js.pusher.com/5.0/pusher.min.js"></script>
<script>
    var pusher = new Pusher('9d11fb3b771888dfb1b0', {
        cluster: 'ap1',
        forceTLS: true
    });

    var channel = pusher.subscribe('task-channel');
    channel.bind('task-created', function(data) {
        console.log();
        getUsername(data.tasks.assigned_to);
    });

    function getUsername(id)
    {
        $.ajax({
            'url'   : '{{route('user.data')}}',
            'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            'type'  : 'POST',
            'data'  : {'id' : id},
            'cache' : false,
            success: function (result) {
                $.notify("A new Task Created was assigned to: "+result, "success");
            },error: function (result) {
                console.log(result.status);
            }
        });
    }
</script>
@yield('extra_script')

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>