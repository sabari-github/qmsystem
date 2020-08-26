@extends('layouts.welcome-app')

@section('content')
    <style type="text/css">
        #result{
            color: red;
        }
    </style>
    <!-- slider_area_start -->
    <div class="bradcam_area breadcam_bg overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>{{$shopbyown->name}}</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- slider_area_end -->

    <!-- about_area_start -->
    <div class="about_area ">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="about_thumbs">
                        @if($shopbyown->image)
                            <img src="{{ URL::asset('resources/assets/uploads/'.$shopbyown->image) }}" alt="">
                        @endif
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="about_info">
                        <div class="section_title mb-20px">
                            <h3>{{ trans('messages.lbl_about_us') }} {{$shopbyown->name}}</h3>
                            <p>{{$shopbyown->remarks}}</p>
                        </div>
                        <p class="opening_hour">
                            {{ trans('messages.lbl_opening_hours') }}
                            <span>{{ \Carbon\Carbon::parse($shopbyown->starttime)->format('H:i')}} {{ trans('messages.lbl_am') }} - {{ \Carbon\Carbon::parse($shopbyown->endtime)->format('H:i')}} {{ trans('messages.lbl_pm') }}</span>
                        </p>
                        <a href="{{url('/')}}" class="boxed-btn3">{{ trans('messages.lbl_backtohome') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about_area_end -->

    @if(session()->has('message'))
        <div styles="alret alert-success" style="text-align: center;color:red;">{{ session()->get('message') }}
        </div>
    @endif
    <div class="service_area">
        <div class="container">
            <div class="row justify-content-center ">
                <h3 class="mb-10">{{ trans('messages.lbl_queue_details') }}</h3>
                <table id="productSizes" class="table">
                    <thead>
                        <tr class="d-flex">
                            <th class="col-1">{{ trans('messages.tbl_no') }}</th>
                            <th class="col-2">{{ trans('messages.lnk_service') }}</th>
                            <th class="col-3">{{ trans('messages.tbl_queue_no') }}</th>
                            <th class="col-4">{{ trans('messages.tbl_queue_time') }}</th>
                            <th class="col-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($queues as $key => $queue)
                        @if(Auth::user()->email == $queue['email'])
                            <?php $color = 'blue;'; ?>
                        @else
                            <?php $color = 'black;'; ?>
                        @endif
                        <tr class="d-flex" style='color:{{$color}}'>
                            <td class="col-1">
                            {{ $key + 1 }}</td>
                            <td class="col-2">{{ $queue['servicename'] }}</td>
                            <td class="col-3">{{ $queue['token_number'] }}</td>
                            <td class="col-4">{{ $queue['queue_time'] }}</td>
                            <td class="col-2">
                                @if(Auth::user()->email == $queue['email'])
                                    <a href="javascript:cancelToken('{{ $queue['qid'] }}', '{{ $queue['shop_id'] }}');" 
                                    class="genric-btn danger-border circle">{{ trans('messages.lbl_cancel') }}</a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="4" style="color:red;font-weight: bold;">
                                {{ trans('messages.tbl_no_queue_data') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="prising_area">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-6">
                    <div class="section_title mb-55">
                        <h3>{{ trans('messages.lbl_our_pricing') }}</h3>
                        <span id="result"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="prising_slider_active owl-carousel">
                        <div class="prising_active d-flex justify-content-between">
                            <div class="single_prising">
                                @forelse($servicesbyshop as $key => $service)
                                <div class="prise_title">
                                    <h4>{{ $service->name }}</h4>
                                </div>
                                <div class="single_service">
                                    <div class="service_inner">
                                        <div class="thumb">
                                            <img src="{{ URL::asset('resources/assets/uploads/'.$service->image) }}" alt="">
                                        </div>
                                    </div>
                                    <div class="hair_style_info">
                                        <div class="prise d-flex justify-content-between">
                                            <span>{{ $service->name }}</span>
                                            
                                        </div>
                                        <p>{{ trans('messages.lbl_service_time') }}：{{ $service->estimatedtime }} 時・分
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="javascript:tokenReg('{{ $service->id }}','{{ $service->shop_id }}')" class="genric-btn success medium">{{ trans('messages.lbl_make_appoinment') }}
                                            </a>
                                        </p>
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

    {{ Form::open(array('url' => 'byShop/tokenCancel','id' => 'cancelfrm','method' => 'POST','files'=>'true')) }}
    {{ Form::hidden('qid', '', array('id' => 'qid')) }}
    {{ Form::hidden('shop_id', '', array('id' => 'shop_id')) }}
    {{ Form::close() }}

    <script type="text/javascript">
        
        function tokenReg(service_id, shop_id) {
            $("#result").empty();
            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });

            var service_id = service_id;
            var shop_id = shop_id;

            $.ajax({

               type:'POST',

               url:'../tokenReg',

               data:{service_id:service_id, shop_id:shop_id},

                dataType:'json',

                success:function(data){

                    $("#result").html(data);
                },
               error:function(){

                $("#result").html("Token Already Registered");
               }

            });
        }

        function cancelToken(qid, shop_id) {
            
            if (!confirm('{{ trans('messages.token_cancel_confirm_msg') }}')) {
                return false;
            }
            $('#cancelfrm #qid').val(qid);
            $('#cancelfrm #shop_id').val(shop_id);
            $("#cancelfrm").submit();
        }

    </script>

    @include('layouts.footer')

@endsection