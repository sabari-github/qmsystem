@extends('layouts.admin-menu')

@section('content')
<script type="text/javascript">
  function mkvalidInvalid(id, validflg){
    $('#validstatuschangefrm #id').val(id);
    $('#validstatuschangefrm #validflg').val(validflg);
    $('#validstatuschangefrm').submit();
  }
</script>
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
            <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.lbl_list') }}</li>
          </ol>
        </nav>
      </div>
    </div>
    <!--  -->
    <div class="content-viewport">
            <div class="row">
              <div class="col-lg-12">
                @include('layouts.flash')
                <!-- <x-alert>
                  <h1>alert msg</h1>
                </x-alert> -->
                <div class="grid">
                  <p class="grid-header">{{ trans('messages.lbl_service_details') }} &nbsp
                    <a href="{{ url('admin/service/create') }}" class="btn btn-primary btn-rounded">{{ trans('messages.lbl_create_service') }}</a>
                  </p>
                  <div class="item-wrapper">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th class="text-center">{{ trans('messages.tbl_no') }}</th>
                            <th>{{ trans('messages.lbl_service_name') }}</th>
                            <th>{{ trans('messages.lbl_estimated_time') }}</th>
                            <th>{{ trans('messages.lbl_service_tokennumber') }}</th>
                            <th>{{ trans('messages.tbl_created_date') }}</th>
                            <th>{{ trans('messages.tbl_img') }}</th>
                            <th>{{ trans('messages.tbl_options') }}</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse($services as $key => $service)
                          <tr>
                            <td class="text-center">{{ ($services->currentpage()-1) * $services->perpage() + $key + 1  }}</td>
                            <td>{{ $service->name }} 「{{ $service->shop->name }}」</td>
                            <td>{{ \Carbon\Carbon::parse($service->estimatedtime)->format('H:i')}} 時間</td>
                            <td>{{ $service->tokenstartfrom }}</td>
                            <td>{{ $service->created_at->format('Y M d') }}</td>
                            <td>
                              @if($service->image)
                              <img src="{{ URL::asset('resources/assets/uploads/'.$service->image) }}" width="40">
                              @endif
                            </td>
                            <td><!-- <a href="{{url('/admin/service/edit',$service->id)}}" alt="Edit">
                              <i class="mdi mdi-pencil"></i>
                            </a> -->
                            <a href="{{url('/admin/service/'.$service->id.'/edit')}}" alt="Edit">
                              <i class="mdi mdi-pencil" style="font-size: 25px;color: orange"></i>
                            </a>
                            @if($service->validflg)
                            <a href="javascript:mkvalidInvalid('{{$service->id}}',0)" alt="Edit">
                              <i class="mdi mdi-check-circle" style="font-size: 25px;color: green"></i>
                            </a>
                            @else
                            <a href="javascript:mkvalidInvalid('{{$service->id}}',1)" alt="Edit">
                              <i class="mdi mdi-check-circle-outline" style="font-size: 25px;color: gray"></i>
                            </a>
                            @endif
                            </td>
                          </tr>
                          @empty
                            <tr>
                              <td colspan="6" style="text-align: center;">{{ trans('messages.tbl_no_data') }}</td>
                            </tr>
                          @endforelse
                        </tbody>
                      </table>
                    </div>
                  </div>{{ $services->links() }}
                </div>
              </div>
              
              
              
            </div>
          </div>
          <form id="validstatuschangefrm" method="post" action="{{route('admin.service.mkinvalid.submit')}}">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="validflg" id="validflg">
          </form>
    <!--  -->
  </div>
@endsection