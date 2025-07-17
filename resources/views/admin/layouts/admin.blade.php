<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
@php $appsetting =  \DB::table('app_settings')->get()->first(); @endphp
        <title>{{ $appsetting->app_name  }}</title>
        <link rel="icon" href="{{ asset('public/admin/images/logoooo.png') }}" type="image/png" />
        <!--plugins-->
        <link href="{{ asset('public/admin/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/admin/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/admin/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/admin/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/admin/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
        <!-- Bootstrap CSS -->
        <link href="{{ asset('public/admin/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/admin/css/bootstrap-extended.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/admin/css/style.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/admin/css/icons.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('public/admin/bootstrap-icons.css') }}">

        <!-- loader-->
	    <link href="{{ asset('public/admin/css/pace.min.css') }}" rel="stylesheet" />


        <!--Theme Styles-->
        <link href="{{ asset('public/admin/css/dark-theme.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/admin/css/light-theme.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/admin/css/semi-dark.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/admin/css/header-colors.css') }}" rel="stylesheet" />
        
        
        
        
        
        @livewireStyles
        <style>
            .not-allowed
            {
                cursor: not-allowed;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <!--start wrapper-->
        <div class="wrapper">
            <!--start top header-->
            <header class="top-header">        
                <nav class="navbar navbar-expand">
                    <div class="mobile-toggle-icon d-xl-none">
                        <i class="bi bi-list"></i>
                    </div>
                    <div class="top-navbar-right d-xl-flex ms-auto ms-3">
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                                    <div class="user-setting d-flex align-items-center gap-1">
                                        <img src="{{ $appsetting->app_icon }}" class="user-img"  style="width: 35px!important;
    height: 30px!important;" alt="">
                                        <div class="user-name d-none d-sm-block">{{ Auth::guard('admin')->user()->name }}</div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $appsetting->app_icon }}" alt="" class="rounded-circle" style="width: 35px!important;
    height: 30px!important;">
                                                <div class="ms-3">
                                                    <h6 class="mb-0 dropdown-user-name">{{ Auth::guard('admin')->user()->name }}</h6>
                                                    <small class="mb-0 dropdown-user-designation text-secondary">{{ Auth::guard('admin')->user()->name }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <div class="d-flex align-items-center">
                                                <div class="setting-icon"><i class="bi bi-speedometer"></i></div>
                                                <div class="setting-text ms-3"><span>Dashboard</span></div>
                                            </div>
                                        </a>
                                    </li>
                                   
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.changePassword') }}">
                                            <div class="d-flex align-items-center">
                                                <div class="setting-icon"><i class="bi bi-gear-fill"></i></div>
                                                <div class="setting-text ms-3"><span>Change Password</span></div>
                                            </div>
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.logout') }}">
                                            <div class="d-flex align-items-center">
                                                <div class="setting-icon"><i class="bi bi-lock-fill"></i></div>
                                                <div class="setting-text ms-3"><span>Logout</span></div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="nav-item dropdown dropdown-large d-none">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                                    <div class="messages">
                                        <span class="notify-badge">5</span>
                                        <i class="bi bi-messenger"></i>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end p-0">
                                    <div class="p-2 border-bottom m-2">
                                        <h5 class="h5 mb-0">Messages</h5>
                                    </div>
                                    <div class="header-message-list p-2">
                                        
                                    </div>
                                    <div class="p-2">
                                        <div><hr class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">
                                            <div class="text-center">View All Messages</div>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                                    <div class="notifications">
                                        <span class="notify-badge">8</span>
                                        <i class="bi bi-bell-fill"></i>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end p-0">
                                    <div class="p-2 border-bottom m-2">
                                        <h5 class="h5 mb-0">Notifications</h5>
                                    </div>
                                    <div class="header-notifications-list p-2">
                                        <div class="dropdown-item bg-light radius-10 mb-1">
                                            <form class="dropdown-searchbar position-relative">
                                                <div class="position-absolute top-50 start-0 translate-middle-y px-3 search-icon"><i class="bi bi-search"></i></div>
                                                <input class="form-control" type="search" placeholder="Search Messages">
                                            </form>
                                        </div>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex align-items-center">
                                                <div class="notification-box"><i class="bi bi-basket2-fill"></i></div>
                                                <div class="ms-3 flex-grow-1">
                                                    <h6 class="mb-0 dropdown-msg-user">New Orders <span class="msg-time float-end text-secondary">1 m</span></h6>
                                                    <small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">You have recived new orders</small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="p-2">
                                        <div><hr class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">
                                            <div class="text-center">View All Notifications</div>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--end top header-->
@php $appsetting =  \DB::table('app_settings')->get()->first(); @endphp
            <!--start sidebar -->
            <aside class="sidebar-wrapper" data-simplebar="true">
                <div class="sidebar-header">
                    <div>
                        <img src="{{ $appsetting->app_icon }}" class="logo-icon" alt="logo icon">
                    </div>
                    <div>
                        <h4 class="logo-text">{{ $appsetting->app_name  }}</h4>
                    </div>
                    <div class="toggle-icon ms-auto"><i class="bi bi-chevron-double-left"></i></div>
                </div>
                <!--navigation-->
                <ul class="metismenu" id="menu">
                    <li class="menu-label">Admin Dashboard</li>
                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            <div class="parent-icon"><i class="bi bi-house-door"></i></div>
                            <div class="menu-title">Dashboard</div>
                        </a>
                    </li>
                    <li class="menu-label">Members</li>
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="bi bi-person"></i></div>
                            <div class="menu-title">Users</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('admin.user') }}"><i class="bi bi-arrow-right-short"></i>User List</a></li>
                            <li><a href="{{ route('admin.user.create') }}"><i class="bi bi-arrow-right-short"></i>Add New User</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="bi bi-person-bounding-box"></i></div>
                            <div class="menu-title">Providers</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('admin.provider') }}"><i class="bi bi-arrow-right-short"></i>Provider List</a></li>
                            <li><a href="{{route('admin.provider.create') }}"><i class="bi bi-arrow-right-short"></i>Add New Provider</a></li>
                            <li>
                                <a href="javascript:;" class="has-arrow">
                                    <i class="bi bi-arrow-right-short"></i>Withdrawal
                                </a>
                                <ul class="mm-collapse">
                                    <li>
                                        <a href="{{ route('admin.provider.withdrawal.pending') }}"><i class="bi bi-arrow-right-short"></i>Pending Request</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.provider.withdrawal.approve') }}"><i class="bi bi-arrow-right-short"></i>Approved Request</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.provider.withdrawal.decline') }}"><i class="bi bi-arrow-right-short"></i>Decline Request</a>
                                    </li>
                                    
                        </ul>
                        </ul>
                    </li>
                    <li class="menu-label">General</li>
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="bi bi-bookmark-heart-fill"></i></div>
                            <div class="menu-title">Vehicle</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('admin.vehicle') }}"><i class="bi bi-arrow-right-short"></i>Add Vehicle Type</a></li>
                             <li><a href="{{ route('admin.vehicle.list') }}"><i class="bi bi-arrow-right-short"></i>Vehicle Type List</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="bi bi-life-preserver"></i></div>
                            <div class="menu-title">Services</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('admin.service.serviceList') }}"><i class="bi bi-arrow-right-short"></i>Service List</a></li>
                            <li><a href="{{ route('admin.service.addService') }}"><i class="bi bi-arrow-right-short"></i>Add Service</a></li>
                            <li><a href="{{ route('admin.service.subServiceList') }}"><i class="bi bi-arrow-right-short"></i>Sub Service List</a></li>
                            <li><a href="{{ route('admin.service.addSubService') }}"><i class="bi bi-arrow-right-short"></i>Add Sub Service</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="bi bi-question-circle-fill"></i></div>
                            <div class="menu-title">Question</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('admin.question') }}"><i class="bi bi-arrow-right-short"></i>Question List</a></li>
                            <li><a href="{{ route('admin.question.create') }}"><i class="bi bi-arrow-right-short"></i>Add Question</a></li>
                        </ul>
                    </li>
                    <!--<li>-->
                    <!--    <a href="javascript:;" class="has-arrow">-->
                    <!--        <div class="parent-icon"><i class="bi bi-bookmark-heart-fill"></i></div>-->
                    <!--        <div class="menu-title">Dress Code</div>-->
                    <!--    </a>-->
                    <!--    <ul>-->
                    <!--        <li><a href="{{ route('admin.dress') }}"><i class="bi bi-arrow-right-short"></i>Dress Code List</a></li>-->
                    <!--    </ul>-->
                    <!--</li>-->
                    
                    
                    
                    <li>
                        <a class="has-arrow" href="javascript:;">
                            <div class="parent-icon"><i class="bi bi-award"></i></div>
                            <div class="menu-title">App Setting</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('admin.legal') }}"><i class="bi bi-arrow-right-short"></i>Legal</a></li>
                            <li><a href="{{ route('admin.commission') }}"><i class="bi bi-arrow-right-short"></i>Admin Commission</a></li>
                            
                            <li><a href="{{ route('admin.appsetting') }}"><i class="bi bi-arrow-right-short"></i> App Update</a></li>
                             <li><a href="{{ route('admin.banner.edit') }}"><i class="bi bi-arrow-right-short"></i> Banner Update</a></li>
                        </ul>
                    </li>
                    
                    
                    
                     
                    
                    
                  
                    <li class="menu-label">Booking</li>
                    <li>
                        <a class="has-arrow" href="javascript:;">
                            <div class="parent-icon"><i class="bi bi-award"></i></div>
                            <div class="menu-title">Bookings</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('admin.bookingHistory') }}"><i class="bi bi-arrow-right-short"></i>Booking History</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:;">
                            <div class="parent-icon"><i class="bi bi-bookmark-star-fill"></i></div>
                            <div class="menu-title">Review</div>
                        </a>
                        <ul>
                            <li><a href="{{ route('admin.review.user') }}"><i class="bi bi-arrow-right-short"></i>User Review </a></li>
                        </ul>
                    </li>
                    
                    
                    
                    
                </ul>
                <!--end navigation-->
            </aside>
            <!--end sidebar -->

            <!-- Page Content -->
            <main class="page-content">
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        
        <!-- Bootstrap bundle JS -->
        <script src="{{ asset('public/admin/js/bootstrap.bundle.min.js') }}"></script>
        <!--plugins-->
        <script src="{{ asset('public/admin/js/jquery.min.js') }}"></script>
        <script src="{{ asset('public/admin/plugins/simplebar/js/simplebar.min.js') }}"></script>
        <script src="{{ asset('public/admin/plugins/metismenu/js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('public/admin/plugins/easyPieChart/jquery.easypiechart.js') }}"></script>
        <script src="{{ asset('public/admin/plugins/peity/jquery.peity.min.js') }}"></script>
        <script src="{{ asset('public/admin/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('public/admin/js/pace.min.js') }}"></script>
        <script src="{{ asset('public/admin/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/admin/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('public/admin/js/table-datatable.js') }}"></script>
        <script src="{{ asset('public/admin/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
	    <script src="{{ asset('public/admin/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
        <script src="{{ asset('public/admin/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
        
        <!--notification js -->
	    <script src="{{ asset('public/admin/plugins/notifications/js/lobibox.min.js') }}"></script>
	    <script src="{{ asset('public/admin/plugins/notifications/js/notifications.min.js') }}"></script>
    	<script src="{{ asset('public/admin/plugins/notifications/js/notification-custom-script.js') }}"></script>
        	
        <!--app-->
        <script src="{{ asset('public/admin/js/app.js') }}"></script>
        <script src="{{ asset('public/admin/js/index.js') }}"></script>
        
        <script>
            $(document).ready(function(){
                $("div.alert").delay(5000).slideUp(700);
            });
        </script>
        
        <!--Update User Status-->
        <script>
            $(function() {
                $('.user-status').change(function() {
                    //alert('hello');
                    var status = $(this).prop('checked') == true ? 1 : 0; 
                    var id = $(this).data('id'); 
             
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: "{{route('admin.user.updateStatus')}}",
                        data: {'status': status, 'id': id},
                        success: function(data){
                            //alert(data.success);
                            window.location = data.url;
                        }
                    });
                })
            })
        </script>
        
        <!--Update Service Status-->
        <script>
            $(function() {
                $('.service-status').change(function() {
                    //alert('hello');
                    var status = $(this).prop('checked') == true ? 1 : 0; 
                    var id = $(this).data('id'); 
             
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: "{{route('admin.service.updateServiceStatus')}}",
                        data: {'status': status, 'id': id},
                        success: function(data){
                            //alert(data.success);
                            window.location = data.url;
                        }
                    });
                })
            })
        </script>
        
        <!--Update Sub Service Status-->
        <script>
            $(function() {
                $('.sub-service-status').change(function() {
                    //alert('hello');
                    var status = $(this).prop('checked') == true ? 1 : 0; 
                    var id = $(this).data('id'); 
             
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: "{{route('admin.service.updateSubServiceStatus')}}",
                        data: {'status': status, 'id': id},
                        success: function(data){
                            //alert(data.success);
                            window.location = data.url;
                        }
                    });
                })
            })
        </script>
        
        <!--Update Question Status-->
        <script>
            $(function() {
                $('.question-status').change(function() {
                    //alert('hello');
                    var status = $(this).prop('checked') == true ? 0 : 1; 
                    var id = $(this).data('id'); 
             
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: "{{route('admin.question.updateStatus')}}",
                        data: {'status': status, 'id': id},
                        success: function(data){
                            //alert(data.success);
                            window.location = data.url;
                        }
                    });
                })
            })
        </script>
        
        <!--Update Question Status-->
        <script>
            $(function() {
                $('.dress-status').change(function() {
                    //alert('hello');
                    var status = $(this).prop('checked') == true ? 0 : 1; 
                    var id = $(this).data('id'); 
             
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: "{{route('admin.dress.updateStatus')}}",
                        data: {'status': status, 'id': id},
                        success: function(data){
                            //alert(data.success);
                            window.location = data.url;
                        }
                    });
                })
            })
        </script>
        
        <script>
            $('#edit').click(function(){ // click to
                document.getElementById("name").classList.remove("not-allowed");
                document.getElementById('name').readOnly  = false;
                document.getElementById("email").classList.remove("not-allowed");
                document.getElementById('email').readOnly  = false;
                document.getElementById("formFile").classList.remove("not-allowed");
                document.getElementById('formFile').disabled  = false;
                document.getElementById("address").classList.remove("not-allowed");
                document.getElementById('address').readOnly  = false;
                document.getElementById("country").classList.remove("not-allowed");
                document.getElementById('country').disabled = false;
                document.getElementById("state").classList.remove("not-allowed");
                document.getElementById('state').readOnly  = false;
                document.getElementById("city").classList.remove("not-allowed");
                document.getElementById('city').readOnly  = false;
                document.getElementById("pincode").classList.remove("not-allowed");
                document.getElementById('pincode').readOnly  = false;
                document.getElementById("about").classList.remove("not-allowed");
                document.getElementById('about').readOnly  = false;
                document.getElementById("update").classList.remove("not-allowed");
                document.getElementById('update').disabled = false;
                document.getElementById('edit').disabled = true;
            });
        </script>
        <script>
            new PerfectScrollbar(".best-product")
            new PerfectScrollbar(".top-sellers-list")
        </script>
    </body>
</html>
