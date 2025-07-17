<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
@php $appsetting =  \DB::table('app_settings')->get()->first(); @endphp
        <title>{{ $appsetting->app_name  }}</title>
        <link rel="icon" href="{{ asset('public/admin/images/logoooo.png') }}" type="image/png" />
        <!-- Bootstrap CSS -->
        <link href="{{ asset('public/admin/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/admin/css/bootstrap-extended.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/admin/css/style.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/admin/css/icons.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('public/admin/bootstrap-icons.css') }}">

        <!-- loader-->
	    <link href="{{ asset('public/admin/css/pace.min.css') }}" rel="stylesheet" />
	    
	    
	    
	    
	    
	    
	    
<link href="{{ asset('public/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

<link href="{{ asset('public/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">

<link href="{{ asset('public/vendor/icofont/icofont.min.css') }}" rel="stylesheet">

<link href="{{ asset('public/vendor/select2/css/select2.min.css') }}" rel="stylesheet">

<link href="{{ asset('public/vendor/select2/osahan.css') }}" rel="stylesheet">
	    
	    
	    
	    
	    @livewireStyles
</head>

<body class="bg-surface">

  <!--start wrapper-->
  <div class="wrapper">
    
        <!--start content-->
        <main class="authentication-content">
            {{ $slot }}
        </main>
         
        <!--end page main-->

        <footer class="bg-white border-top p-3 text-center fixed-bottom">
            <p class="mb-0">Copyright © 2021. All right reserved.Developed by <a href="https://appoks.com/ " target="_blank">appoks Infolabs</a></p>
        </footer>

  </div>
  <!--end wrapper-->

    @stack('modals')
    
    @livewireScripts
    <!-- Bootstrap bundle JS -->
    <script src="{{ asset('public/admin/js/bootstrap.bundle.min.js') }}"></script>

    <!--plugins-->
    <script src="{{ asset('public/admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/admin/js/pace.min.js') }}"></script>

</body>
</html>