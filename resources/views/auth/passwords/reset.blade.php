@extends('layouts.welcome-app')

@section('content')

     <!-- bradcam_area_start -->
     <div class="bradcam_area breadcam_bg overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>{{ trans('messages.lbl_reset_password') }}</h3>
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
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="col-9">
                                <div class="form-group">
                                    <label>{{ trans('messages.lbl_email_address') }}</label>
                                    <input class="form-control @error('email') is-invalid @enderror" name="email" id="email" type="email" 
                                    value="{{ $email ?? old('email') }}" placeholder="{{ trans('messages.plh_email') }}">
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

                            <div class="form-group mt-3">
                                <button type="submit" class="genric-btn success circle">{{ trans('messages.lbl_reset_password') }}</button>
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