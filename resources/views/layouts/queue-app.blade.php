<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Barber</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('resources/assets/img/favicon.png') }}">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    {!! Html::style('resources/assets/css/bootstrap.min.css') !!}
    {!! Html::style('resources/assets/css/owl.carousel.min.css') !!}
    {!! Html::style('resources/assets/css/magnific-popup.css') !!}
    {!! Html::style('resources/assets/css/font-awesome.min.css') !!}
    {!! Html::style('resources/assets/css/themify-icons.css') !!}
    {!! Html::style('resources/assets/css/nice-select.css') !!}
    {!! Html::style('resources/assets/css/flaticon.css') !!}
    {!! Html::style('resources/assets/css/gijgo.css') !!}
    {!! Html::style('resources/assets/css/animate.css') !!}
    {!! Html::style('resources/assets/css/slicknav.css') !!}
    {!! Html::style('resources/assets/css/style.css') !!}
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
    <style type="text/css">
        .error{
            color: red;
        }
        .back-to-top {
            cursor: pointer;
            position: fixed;
            bottom: 20px;
            right: 20px;
            display:none;
        }
    </style>
    
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!-- header-start -->
    <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-3">
                            <div class="logo-img">
                                <a href="{{ url('/') }}" style="color: white;font-weight: bold;">
                                    <!-- <img src="{{ URL::asset('resources/assets/img/logo.png') }}" alt=""> -->
                                    キュー管理システム
                                </a>
                            </div>
                        </div>
                        <?php //print_r($shopsName);exit(); ?>
                        <div class="col-xl-9 col-lg-9">
                            <div class="menu_wrap d-none d-lg-block">
                                <div class="menu_wrap_inner d-flex align-items-center justify-content-end">
                                    <div class="main-menu">
                                        <nav>
                                            <ul id="navigation">
                                                
                                                <li><a href="#">{{ trans('messages.lnk_language') }} <i class="ti-angle-down"></i></a>
                                                    <ul class="submenu">
                                                        <li>
                                                            <a href="{{ url('language/jp') }}">{{ trans('messages.lbl_japanese') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('language/en') }}">{{ trans('messages.lbl_english') }}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                @guest
                                                    <li>
                                                        <a href="{{ route('login') }}">{{ trans('messages.lnk_login') }}
                                                        </a>
                                                    </li>
                                                    @if (Route::has('register'))
                                                        <li>
                                                            <a href="{{ route('register') }}">{{ trans('messages.lnk_register') }}
                                                        </a>
                                                        </li>
                                                    @endif
                                                    @else
                                                        @if(\Illuminate\Support\Facades\Auth::guard('admin')->check())
                                                            <li><a href="#">{{ Auth::user()->name }} <i class="ti-angle-down"></i></a>
                                                                <ul class="submenu">
                                                                    <li><a href="{{ route('admin.logout') }}" 
                                                                        onclick="event.preventDefault();
                                                     document.getElementById('admin-logout-form').submit();">{{ trans('messages.lnk_logout') }}</a>
                                                     <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST"
                                              style="display: none;">
                                            @csrf
                                        </form>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        @else
                                                            <li><a href="#">{{ Auth::user()->name }} <i class="ti-angle-down"></i></a>
                                                                <ul class="submenu">
                                                                    <li><a href="{{ route('user.logout') }}" 
                                                                        onclick="event.preventDefault();
                                                     document.getElementById('user-logout-form').submit();">{{ trans('messages.lnk_logout') }}</a>
                                                     <form id="user-logout-form" action="{{ route('user.logout') }}" method="POST"
                                              style="display: none;">
                                            @csrf
                                        </form>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        @endif
                                                @endguest
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="book_room">
                                        <div class="book_btn">
                                            <!-- <a class="popup-with-form" href="#test-form"> -->
                                            <a href="{{url('admin/queue')}}">{{ trans('messages.lbl_queue_view') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-end -->

    <div>
        @yield('content')
    </div>

    <div id="showpopup" class="white-popup-block mfp-hide">
        <div id="login-overlay">
            <div class="modal-content">
                <!-- Popup will be loaded here -->
            </div>
        </div>
    </div>

    
    <a id="back-to-top" href="#" class="btn btn-outline-secondary back-to-top" role="button" title="{{ trans('messages.lbl_clicktotop') }}" data-toggle="tooltip" data-placement="right">↑</a>

    <!-- form itself end -->

    <!-- JS here -->
    {!! Html::script('resources/assets/js/vendor/modernizr-3.5.0.min.js') !!}
    {!! Html::script('resources/assets/js/vendor/jquery-1.12.4.min.js') !!}
    {!! Html::script('resources/assets/js/popper.min.js') !!}
    {!! Html::script('resources/assets/js/bootstrap.min.js') !!}
    {!! Html::script('resources/assets/js/owl.carousel.min.js') !!}
    {!! Html::script('resources/assets/js/isotope.pkgd.min.js') !!}
    {!! Html::script('resources/assets/js/ajax-form.js') !!}
    {!! Html::script('resources/assets/js/waypoints.min.js') !!}
    {!! Html::script('resources/assets/js/jquery.counterup.min.js') !!}
    {!! Html::script('resources/assets/js/imagesloaded.pkgd.min.js') !!}
    {!! Html::script('resources/assets/js/scrollIt.js') !!}
    {!! Html::script('resources/assets/js/jquery.scrollUp.min.js') !!}
    {!! Html::script('resources/assets/js/wow.min.js') !!}
    {!! Html::script('resources/assets/js/nice-select.min.js') !!}
    
    {!! Html::script('resources/assets/js/jquery.slicknav.min.js') !!}
    {!! Html::script('resources/assets/js/jquery.slicknav.min.js') !!}
    {!! Html::script('resources/assets/js/jquery.magnific-popup.min.js') !!}
    {!! Html::script('resources/assets/js/plugins.js') !!}
    {!! Html::script('resources/assets/js/gijgo.min.js') !!}

    <!--contact js-->
    {!! Html::script('resources/assets/js/contact.js') !!}
    {!! Html::script('resources/assets/js/jquery.ajaxchimp.min.js') !!}
    {!! Html::script('resources/assets/js/jquery.form.js') !!}
    {!! Html::script('resources/assets/js/jquery.validate.min.js') !!}
    {!! Html::script('resources/assets/js/mail-script.js') !!}

    {!! Html::script('resources/assets/js/main.js') !!}
    <script type="text/javascript">
        function appoinmentForm(){ 
            // alert(); return false;
            $('#showpopup').load('appoinmentpopup');

            $("#showpopup").modal({

               backdrop: 'static',

                keyboard: false

            });

            $('#showpopup').modal('show');
        }
    </script>
    <script>
        $('#datepicker').datepicker({
            iconsLibrary: 'fontawesome',
            disableDaysOfWeek: [0, 0],
            format: 'yyyy/mm/dd' 
         //    icons: {
         //     rightIcon: '<span class="fa fa-caret-down"></span>'
         // }
        });
        $('#datepicker2').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
             rightIcon: '<span class="fa fa-caret-down"></span>'
         }

        });
        var timepicker = $('#timepicker').timepicker({
         format: 'HH.MM'
     });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
             $(window).scroll(function () {
                    if ($(this).scrollTop() > 50) {
                        $('#back-to-top').fadeIn();
                    } else {
                        $('#back-to-top').fadeOut();
                    }
                });
                // scroll body to 0px on click
                $('#back-to-top').click(function () {
                    $('#back-to-top').tooltip('hide');
                    $('body,html').animate({
                        scrollTop: 0
                    }, 800);
                    return false;
                });
                
                $('#back-to-top').tooltip('show');

        });
    </script>
    
</body>

</html>