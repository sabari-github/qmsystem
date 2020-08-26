<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard</title>
    <!-- plugins:css -->
    {!! Html::style('resources/admin/assets/vendors/iconfonts/mdi/css/materialdesignicons.css') !!}
    <!-- endinject -->
    <!-- vendor css for this page -->
    <!-- End vendor css for this page -->
    <!-- inject:css -->
    {!! Html::style('resources/admin/assets/css/shared/style.css') !!}
    <!-- endinject -->
    <!-- Layout style -->
    {!! Html::style('resources/admin/assets/css/demo_1/style.css') !!}
    <!-- Layout style -->
    <link rel="shortcut icon" href="{{ URL::asset('resources/admin/assets/images/favicon.ico') }}" />
    <style type="text/css">
      .error{
        color: red;
      }
      .hissumark{
        font-size: 18px;
        color: red;
      }
    </style>
  </head>
  <body class="header-fixed">
    <!-- partial:partials/_header.html -->
    <nav class="t-header">
      <div class="t-header-brand-wrapper">
        <a href="index.html">
          <img class="logo" src="{{ URL::asset('resources/admin/assets/images/logo.svg') }}" alt="">
          <img class="logo-mini" src="{{ URL::asset('resources/admin/assets/images/logo_mini.svg') }}" alt="">
        </a>
      </div>
      <div class="t-header-content-wrapper">
        <div class="t-header-content">
          <button class="t-header-toggler t-header-mobile-toggler d-block d-lg-none">
            <i class="mdi mdi-menu"></i>
          </button>
          <!-- <form action="#" class="t-header-search-box">
            <div class="input-group">
              <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Search" autocomplete="off">
              <button class="btn btn-primary" type="submit"><i class="mdi mdi-arrow-right-thick"></i></button>
            </div>
          </form> -->
          <ul class="nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" id="notificationDropdown" data-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-translate mdi-1x"></i>
              </a>
              <div class="dropdown-menu navbar-dropdown dropdown-menu-right" aria-labelledby="notificationDropdown">
                <div class="dropdown-header">
                  <h6 class="dropdown-title">{{ trans('messages.lnk_language') }}</h6>
                </div>
                <div class="dropdown-body">
                  <div class="dropdown-list">
                    <div class="icon-wrapper rounded-circle bg-inverse-primary text-primary">
                      JP
                    </div>
                    <a href="{{ url('language/jp') }}" class="content-wrapper">
                      <small class="name">{{ trans('messages.lbl_japanese') }}</small>
                    </a>
                  </div>
                  <div class="dropdown-list">
                    <div class="icon-wrapper rounded-circle bg-inverse-success text-success">
                      EN
                    </div>
                    <a href="{{ url('language/en') }}" class="content-wrapper">
                      <small class="name">{{ trans('messages.lbl_english') }}</small>
                    </a>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- partial -->
    <div class="page-body">
      <!-- partial:partials/_sidebar.html -->
      <div class="sidebar">
        <div class="user-profile">
          <div class="display-avatar animated-avatar">
            <img class="profile-img img-lg rounded-circle" 
            src="{{ URL::asset('resources/admin/assets/images/profile/male/image_1.png') }}" alt="profile image">
          </div>
          <div class="info-wrapper">
            <p class="user-name">{{ Auth::user()->name }}</p>
            <!-- <h6 class="display-income">$3,400,00</h6> -->
          </div>
        </div>
        <ul class="navigation-menu">
          <li class="nav-category-divider">{{ trans('messages.lbl_menu') }}</li>
          <li class="active">
            <a href="{{ url('admin/') }}">
              <span class="link-title">{{ trans('messages.lbl_dashboard') }}</span>
              <i class="mdi mdi-gauge link-icon"></i>
            </a>
          </li>
          <li class="active">
            <a href="{{url('admin/queue')}}">
              <span class="link-title">{{ trans('messages.lbl_queue_view') }}</span>
              <i class="mdi mdi-gauge link-icon"></i>
            </a>
          </li>
          <li>
            <a href="{{ url('admin/shop') }}">
              <span class="link-title">{{ trans('messages.lbl_shop') }}</span>
              <i class="mdi mdi-shopping link-icon"></i>
            </a>
          </li>
          <li>
            <a href="{{ url('admin/service') }}">
              <span class="link-title">{{ trans('messages.lbl_service') }}</span>
              <i class="mdi mdi-shopping link-icon"></i>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.logout') }}" 
                  onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                  <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST"
                                              style="display: none;">
                                            @csrf
                                        </form>
                    <span class="link-title">{{ trans('messages.lnk_logout') }}</span>
                    <i class="mdi mdi-logout link-icon"></i>
                  </a>
          </li>
        </ul>
      </div>
      @yield('content')
      <!-- page content ends -->
    </div>
    <!--page body ends -->
    <!-- SCRIPT LOADING START FORM HERE /////////////-->
    <!-- plugins:js -->
    
    {!! Html::script('resources/admin/assets/vendors/js/core.js') !!}
    <!-- endinject -->
    <!-- Vendor Js For This Page Ends-->
    {!! Html::script('resources/admin/assets/vendors/apexcharts/apexcharts.min.js') !!}
    
    {!! Html::script('resources/admin/assets/vendors/chartjs/Chart.min.js') !!}
    
    {!! Html::script('resources/admin/assets/js/charts/chartjs.addon.js') !!}
    <!-- Vendor Js For This Page Ends-->
    <!-- build:js -->
    
    {!! Html::script('resources/admin/assets/js/template.js') !!}
    
    {!! Html::script('resources/admin/assets/js/dashboard.js') !!}
    <!-- endbuild -->
  </body>
</html>