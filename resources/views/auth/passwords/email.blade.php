@extends('layouts.welcome-app')

@section('content')

     <!-- bradcam_area_start -->
     <div class="bradcam_area breadcam_bg overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>{{ trans('messages.lbl_forgot_password') }}</h3>
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
                        <form class="form-contact contact_form" action="{{ route('password.email') }}" method="post" >
                            @csrf
                            <div class="row">
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
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="genric-btn success circle">{{ trans('messages.btn_Send_Password_Reset_Link') }}</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
                @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
            </div>
        </section>
    <!-- ================ contact section end ================= -->
    
@endsection