@extends('layouts.welcome-app')

@section('content')

     <!-- bradcam_area_start -->
     <div class="bradcam_area breadcam_bg overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>{{ trans('messages.lbl_login') }}</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam_area_end -->

    <!-- ================ contact section start ================= -->
    <section class="contact-section">
            <div class="container">    
    
                <div class="row">
                    <div class="col-12">
                        <!-- <h2 class="contact-title">{{ trans('messages.lbl_login') }}</h2> -->
                    </div>
                    <div class="col-lg-8">
                        <form class="form-contact contact_form" action="{{ route('login') }}" method="post" >
                            @csrf
                            <div class="row">
                                <div class="col-9">
                                    <div class="form-group">
                                        <label>{{ trans('messages.lbl_emailAddress') }}</label>
                                        <input class="form-control @error('email') is-invalid @enderror" name="email" id="email" type="email" 
                                        value="{{ Cookie::get('email') ? Cookie::get('email') : old('email') }}" placeholder="{{ trans('messages.plh_username') }}">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group">
                                        <label>{{ trans('messages.lbl_password') }}</label>
                                        <input class="form-control @error('password') is-invalid @enderror" name="password" id="password" type="password" 
                                        placeholder="{{ trans('messages.plh_password') }}">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" 
                                            {{ Cookie::get('remember') ? 'checked' : '' }}> {{ trans('messages.lnk_remindme') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="genric-btn success circle">{{ trans('messages.btn_login') }}</button>
                                <!-- <a class="btn btn-link" href="{{ url('/password/reset') }}">{{ trans('messages.lnk_forgatpassword') }}</a> -->
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ trans('messages.lnk_forgatpassword') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                    
                </div>
                @if(Session::has('error'))
        <center><span class="error">{{ Session::get('error') }}</span></center>
    @endif
            </div>
        </section>
    <!-- ================ contact section end ================= -->
    
@endsection