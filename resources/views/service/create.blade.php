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
              <a href="{{ url('admin/shop') }}">{{ trans('messages.lbl_service') }}</a>
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
                  <p class="grid-header">{{ trans('messages.lbl_add_new_service') }}</p>
                  <div class="grid-body">
                    <div class="item-wrapper">
                      <form method="POST" action="{{ route('admin.service.create.submit') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row showcase_row_area">
                          <div class="col-md-3 showcase_text_area">
                            <label for="inputEmail4">{{ trans('messages.lbl_shop_name') }} <span class="hissumark">*</span></label>
                          </div>
                          <div class="col-md-9 showcase_content_area">
                            {{ Form::select('shop_id',[null=>''] + $shopsName,null, array('name' => 'shop_id',
                              'id'=>'shop_id','class'=>'form-control'))
                            }}
                            @error('shop_id')
                              <span class="error" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                          </div>
                        </div>
                        <div class="form-group row showcase_row_area">
                          <div class="col-md-3 showcase_text_area">
                            <label for="inputEmail10">{{ trans('messages.lbl_service_name') }} <span class="hissumark">*</span></label>
                          </div>
                          <div class="col-md-9 showcase_content_area">
                            <input type="text" class="form-control" id="inputEmail10" placeholder="{{ trans('messages.lbl_enter_service_name') }}" name="name" 
                            value="{{ old('name') }}">
                            <input type="hidden" name="conditionFlg" value="">
                            @error('name')
                              <span class="error" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                          </div>
                        </div>
                        <div class="form-group row showcase_row_area">
                          <div class="col-md-3 showcase_text_area">
                            <label for="inputEmail4">{{ trans('messages.lbl_estimated_time') }} <span class="hissumark">*</span></label>
                          </div>
                          <div class="col-md-4 showcase_content_area">
                            <input type="time" class="form-control" id="inputEmail4" placeholder="{{ trans('messages.lbl_start_time') }}" 
                            name="estimatedtime">
                            <span class="mute" role="alert">
                                <strong>例：10:00</strong>
                            </span><br/>
                            @error('estimatedtime')
                              <span class="error" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                          </div>
                        </div>
                        <div class="form-group row showcase_row_area">
                          <div class="col-md-3 showcase_text_area">
                            <label for="inputEmail10">{{ trans('messages.lbl_service_tokennumber') }} <span class="hissumark">*</span></label>
                          </div>
                          <div class="col-md-9 showcase_content_area">
                            <input type="text" class="form-control" id="inputEmail10" placeholder="{{ trans('messages.lbl_enter_service_tokennumber') }}" name="tokenstartfrom" 
                            >
                            @error('tokenstartfrom')
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
                          <button type="submit" class="btn btn-sm btn-primary">{{ trans('messages.lbl_create_service') }}</button>
                          <a href="{{ url('admin/service') }}" class="btn btn-sm btn-danger">{{ trans('messages.lbl_cancel') }}</a>
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