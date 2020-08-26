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
              <a href="{{ url('admin/service') }}">{{ trans('messages.lbl_service') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.lbl_edit') }}</li>
          </ol>
        </nav>
      </div>
    </div>
    <!--  -->
    <div class="content-viewport">
            <div class="row">
              <div class="col-lg-9 equel-grid">
                <div class="grid">
                  <p class="grid-header">{{ trans('messages.lbl_edit_service_details') }}</p>
                  <div class="grid-body">
                    <div class="item-wrapper">
                      <!-- <form method="POST" action="{{ route('admin.shop.create.submit') }}" enctype="multipart/form-data"> -->
                        {{ Form::model($service, array('name'=>'update_service','id'=>'update_service','url' => 'admin/service/'.$service->id.'/update/','files'=>true,'method' => 'POST')) }}
         
                        @csrf
                        @method('patch')
                        <div class="form-group row showcase_row_area">
                          <div class="col-md-3 showcase_text_area">
                            <label for="inputEmail10">{{ trans('messages.lbl_shop_name') }} <span class="hissumark">*</span></label>
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
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputEmail10" placeholder="{{ trans('messages.lbl_enter_shop_name') }}" name="name" 
                            value="{{ $service->name }}">
                            <input type="hidden" name="conditionFlg" value="">
                            @error('name')
                              <span class="error" role="alert">
                                  <strong>{{ $message }} <span class="hissumark">*</span></strong>
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
                            name="estimatedtime" value="{{ $service->estimatedtime }}">
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
                            <span class="form-control">{{ $service->tokenstartfrom }}</span>
                            <input type="hidden" name="tokenstartfrom" 
                            value="{{ $service->tokenstartfrom }}">
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
                              <input type="hidden" name="old_id" value="{{ $service->id }}">
                              <input type="hidden" name="old_image_name" value="{{ $service->image }}">
                              <label class="custom-file-label" for="customFile">Choose file</label>
                              {{ ($service->image) ? $service->image : '' }}
                            </div>
                          </div>
                        </div>
                        <div class="form-group row showcase_row_area">
                          <div class="col-md-3 showcase_text_area">
                            <label for="inputType9">{{ trans('messages.lbl_remark') }}</label>
                          </div>
                          <div class="col-md-9 showcase_content_area">
                            {{ Form::textarea('remarks',null, 
                                array('name' => 'remarks','id' => 'remarks',
                                      'class' => 'form-control','size' => '12x5'))
                            }}
                          </div>
                        </div>
                        <center>
                          <button type="submit" class="btn btn-sm btn-primary">{{ trans('messages.lbl_update_service') }}</button>
                          <a href="{{ url('admin/service') }}" class="btn btn-sm btn-danger">{{ trans('messages.lbl_cancel') }}</a>
                        </center>
                      {{ Form::close() }}
                      <!-- </form> -->
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
    <!--  -->
  </div>
@endsection