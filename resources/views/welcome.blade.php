@extends('layouts.welcome-app')

@section('content')
    <!-- slider_area_start -->
    <div class="bradcam_area breadcam_bg overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>キュー管理システム</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- slider_area_end -->

    <!-- about_area_start -->
    <!-- <div class="about_area ">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="about_thumbs">
                        <div class="large_img_1">
                            <img src="{{ URL::asset('resources/assets/img/about/about_lft.png') }}" alt="">
                        </div>
                        <div class="small_img_1">
                            <img src="{{ URL::asset('resources/assets/img/about/about_right.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="about_info">
                        <div class="section_title mb-20px">
                            <h3>{{ trans('messages.lbl_about_us') }} {{$singleShop->name}}</h3>
                            <p>{{$singleShop->remarks}}</p>
                        </div>
                        <p class="opening_hour">
                            {{ trans('messages.lbl_opening_hours') }}
                            <span>{{ \Carbon\Carbon::parse($singleShop->starttime)->format('H:i')}} {{ trans('messages.lbl_am') }} - {{ \Carbon\Carbon::parse($singleShop->endtime)->format('H:i')}} {{ trans('messages.lbl_pm') }}</span>
                        </p>
                        <a href="{{url('/byShop/'.$singleShop->id.'/service')}}" class="boxed-btn3">{{ trans('messages.lbl_about_us_ind') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="row justify-content-center ">
        <div class="col-lg-6 col-md-10">
            <div class="section_title text-center mb-15">
                <h2>{{ trans('messages.lbl_our_shops') }}</h2>
            </div>
        </div>
    </div>
    @forelse($shops as $key => $shop)
    <div class="about_area ">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="about_thumbs">
                        @if($shop->image)
                            <img src="{{ URL::asset('resources/assets/uploads/'.$shop->image) }}" alt="">
                        @endif
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="about_info">
                        <div class="section_title mb-20px">
                            <h3>{{ trans('messages.lbl_about_us') }} {{$shop->name}}</h3>
                            <p>{{$shop->remarks}}</p>
                        </div>
                        <p class="opening_hour">
                            {{ trans('messages.lbl_opening_hours') }}
                            <span>{{ \Carbon\Carbon::parse($shop->starttime)->format('H:i')}} {{ trans('messages.lbl_am') }} - {{ \Carbon\Carbon::parse($shop->endtime)->format('H:i')}} {{ trans('messages.lbl_pm') }}</span>
                        </p>
                        <a href="{{url('/byShop/'.$shop->id.'/service')}}" class="boxed-btn3">{{ trans('messages.lbl_about_us_ind') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
        <h3>Please Register Shops</h3>
    @endforelse
    <!-- about_area_end -->

    <div class="service_area">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-lg-6 col-md-10">
                    <div class="section_title text-center mb-55">
                        <h3>{{ trans('messages.lbl_our_service') }}</h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @forelse($services as $key => $service)
                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                         <div class="service_thumb">
                             <img src="{{ URL::asset('resources/assets/uploads/'.$service->image) }}" alt="">
                         </div>
                         <div class="service_content text-center">
                            <div class="icon">
                                <i class="flaticon-shave"></i>
                            </div>
                            <h3>{{ $service->name }}</h3>
                            <p>{{ $service->remarks }}</p>
                         </div>
                    </div>
                </div>
                @empty
                    <h3>Please Register Service</h3>
                @endforelse
            </div>
        </div>
    </div>

    @include('layouts.footer')

@endsection