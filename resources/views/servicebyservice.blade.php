@extends('layouts.welcome-app')

@section('content')
    <!-- slider_area_start -->
    <div class="slider_area">
        <div class="slider_active owl-carousel">
            <div class="single_slider d-flex align-items-center justify-content-center slider_bg_1 overlay">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-8">
                            <div class="slider_text">
                                <h3>{{ trans('messages.lbl_shop_message') }}</h3>
                                <a href="{{url('queue')}}" class="boxed-btn3">{{ trans('messages.lnk_appoinment') }}</a>
                                <a href="#test-form" class="popup-with-form boxed-btn3">{{ trans('messages.lbl_queue_view') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider_area_end -->

    <!-- about_area_start -->
    @forelse($servicesbyservice as $key => $shop)
    <div class="about_area ">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="about_thumbs">
                        @if($shop->image)
                            <img src="{{ URL::asset('resources/assets/uploads/'.$shop->shop->image) }}" alt="">
                        @endif
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="about_info">
                        <div class="section_title mb-20px">
                            <h3>{{ trans('messages.lbl_about_us') }} {{$shop->shop->name}}</h3>
                            <p>{{$shop->shop->remarks}}</p>
                        </div>
                        <p class="opening_hour">
                            {{ trans('messages.lbl_opening_hours') }}
                            <span>{{ \Carbon\Carbon::parse($shop->shop->starttime)->format('H:i')}} {{ trans('messages.lbl_am') }} - {{ \Carbon\Carbon::parse($shop->shop->endtime)->format('H:i')}} {{ trans('messages.lbl_pm') }}</span>
                        </p>
                        <a href="{{url('/byShop/'.$shop->shop->id.'/service')}}" class="boxed-btn3">{{ trans('messages.lbl_about_us_ind') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
        <h3>Please Register Shops</h3>
    @endforelse
    <!-- about_area_end -->

    <div class="prising_area">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-6">
                    <div class="section_title mb-55">
                        <h3>{{ trans('messages.lbl_our_pricing') }}</h3>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="prising_slider_active owl-carousel">
                        <div class="prising_active d-flex justify-content-between">
                            <div class="single_prising">
                                @forelse($servicesbyservice as $key => $service)
                                <div class="prise_title">
                                    <h4>{{ $service->menu->name }}</h4>
                                </div>
                                <div class="single_service">
                                    <div class="service_inner">
                                        <div class="thumb">
                                            <img src="{{ URL::asset('resources/assets/uploads/'.$service->image) }}" alt="">
                                        </div>
                                    </div>
                                    <div class="hair_style_info">
                                        <div class="prise d-flex justify-content-between">
                                            <span>{{ $service->menu->name }}</span>
                                            <span>{{ number_format($service->price, 0, ",", ",") . " 円" }}</span>
                                        </div>
                                        <p>店舗：{{ $service->shop->name }} </p>
                                    </div>
                                </div>
                                @empty
                                    <h3>Please Register Service</h3>
                                @endforelse
                            </div>
                            
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')

@endsection