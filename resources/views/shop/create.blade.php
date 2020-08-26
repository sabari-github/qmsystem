@extends('layouts.admin-menu')

@section('content')
<!-- partial -->
  <div class="page-content-wrapper">
    <div class="page-content-wrapper-inner">
      <div class="viewport-header">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb has-arrow">
            <li class="breadcrumb-item">
              <a href="{{ url('admin/') }}">{{ trans('messages.lbl_dashboard') }}</a>
            </li>
            <li class="breadcrumb-item">
              <a href="{{ url('admin/shop') }}">{{ trans('messages.lbl_shop') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.lbl_add') }}</li>
          </ol>
        </nav>
      </div>
    </div>
    <!--  -->
    <div class="content-viewport">
            <div class="row">
              <div class="col-lg-9 equel-grid">
                <div class="grid">
                  <p class="grid-header">{{ trans('messages.lbl_add_new_shop') }}</p>
                  <div class="grid-body">
                    <div class="item-wrapper">
                      <form method="POST" action="{{ route('admin.shop.create.submit') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row showcase_row_area">
                          <div class="col-md-3 showcase_text_area">
                            <label for="inputEmail10">{{ trans('messages.lbl_shop_name') }} <span class="hissumark">*</span></label>
                          </div>
                          <div class="col-md-9 showcase_content_area">
                            <input type="text" class="form-control" id="inputEmail10" placeholder="{{ trans('messages.lbl_enter_shop_name') }}" name="name" 
                            value="{{ old('name') }}">
                            @error('name')
                              <span class="error" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                          </div>
                        </div>
                        <div class="form-group row showcase_row_area">
                          <div class="col-md-3 showcase_text_area">
                            <label for="inputEmail4">{{ trans('messages.lbl_opening_hours') }} <span class="hissumark">*</span></label>
                          </div>
                          <div class="col-md-4 showcase_content_area">
                            <input type="time" class="form-control" id="inputEmail4" placeholder="{{ trans('messages.lbl_start_time') }}" 
                            name="starttime">
                            <span class="mute" role="alert">
                                <strong>例：10:00</strong>
                            </span><br/>
                            @error('starttime')
                              <span class="error" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                          </div>
                          <div class="col-md-1 showcase_content_area">
                            <center>～</center>
                          </div>
                          <div class="col-md-4 showcase_content_area">
                            <input type="time" class="form-control" id="inputEmail4" placeholder="{{ trans('messages.lbl_end_time') }}" 
                            name="endtime">
                            <span class="mute" role="alert">
                                <strong>例：20:30</strong>
                            </span><br/>
                            @error('endtime')
                              <span class="error" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                          </div>
                        </div>
                        <div class="form-group row showcase_row_area">
                          <div class="col-md-3 showcase_text_area">
                            <label>{{ trans('messages.lbl_file_upload') }} <span class="hissumark">*</span></label>
                          </div>
                          <div class="col-md-9 showcase_content_area">
                            <div class="custom-file">
                              <input type="file" name="image" class="custom-file-input" id="customFile">
                              <label class="custom-file-label" for="customFile">Choose file</label>
                              @error('image')
                              <span class="error" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                          </div>
                        </div>
                        <div class="form-group row showcase_row_area">
                          <div class="col-md-3 showcase_text_area">
                            <label for="inputType9">{{ trans('messages.lbl_remark') }}</label>
                          </div>
                          <div class="col-md-9 showcase_content_area">
                            <textarea class="form-control" id="inputType9" cols="12" rows="5" name="remarks"></textarea>
                          </div>
                        </div>
                        <center>
                          <button type="submit" class="btn btn-sm btn-primary">{{ trans('messages.lbl_create_shop') }}</button>
                          <a href="{{ url('admin/shop') }}" class="btn btn-sm btn-danger">{{ trans('messages.lbl_cancel') }}</a>
                        </center>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
    <!--  -->
  </div>
@endsection