
<footer class="footer">
    <div class="footer_top">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-md-6 col-lg-5 ">
                    <div class="footer_widget">
                        <div class="footer_logo">
                            <a href="{{ url('/') }}" style="color: white;font-weight: bold;">キュー管理システム
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-lg-3">
                    <div class="footer_widget">
                        <h3 class="footer_title">
                            Information
                        </h3>
                        <ul class="links">
                            <li><a href="{{ route('register') }}">{{ trans('messages.lnk_register') }}</a></li>
                            <li><a href="{{ route('login') }}">{{ trans('messages.lnk_login') }}</a></li>
                        </ul>
                    </div>
                </div>
                <!-- <div class="col-xl-2  col-md-6 col-lg-2">
                    <div class="footer_widget">
                        <h3 class="footer_title">
                            {{ trans('messages.lnk_service') }}
                        </h3>
                        <ul class="links">
                            @forelse($services as $key => $service)
                            <li><a href="{{url('/byService/'.$service->id.'/service')}}">{{ $service->name }}</a></li>
                            @empty
                                <li>Please Register Service</li>
                            @endforelse
                        </ul>
                    </div>
                </div> -->
                <div class="col-xl-2  col-md-6 col-lg-2">
                    <div class="footer_widget">
                        <h3 class="footer_title">
                            {{ trans('messages.lnk_language') }}
                        </h3>
                        <ul class="links">
                            <li><a href="{{ url('language/jp') }}">{{ trans('messages.lbl_japanese') }}</a></li>
                            <li><a href="{{ url('language/en') }}">{{ trans('messages.lbl_english') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer_end 