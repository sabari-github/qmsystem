@extends('layouts.welcome-app')

@section('content')

     <!-- bradcam_area_start -->
     <div class="bradcam_area breadcam_bg overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>{{ trans('messages.lbl_register') }}</h3>
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
                        <form class="form-contact contact_form" action="{{ route('register') }}" method="post" >
                            @csrf
                            <div class="row">
                                <div class="col-9">
                                    <div class="form-group">
                                        <label>{{ trans('messages.lbl_name') }}</label>
                                        <input class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" placeholder="{{ trans('messages.plh_name') }}">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group">
                                        <label>{{ trans('messages.lbl_email_address') }}</label>
                                        <input class="form-control @error('email') is-invalid @enderror" name="email" id="email" type="email" 
                                        value="{{ old('email') }}" placeholder="{{ trans('messages.plh_email') }}">
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
                                    <div class="form-group">
                                        <label>{{ trans('messages.lbl_confirm_password') }}</label>
                                        <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" placeholder="{{ trans('messages.plh_confirm_password') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="genric-btn success circle">{{ trans('messages.btn_register') }}</button>
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