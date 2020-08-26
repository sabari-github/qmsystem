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
              <a href="{{ url('admin/shop') }}">{{ trans('messages.lbl_shop') }}</a>
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
                  <p class="grid-header">{{ trans('messages.lbl_shop_details') }} &nbsp
                    <a href="{{ url('admin/shop/create') }}" class="btn btn-primary btn-rounded">{{ trans('messages.lbl_create_shop') }}</a>
                  </p>
                  <div class="item-wrapper">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th class="text-center">{{ trans('messages.tbl_no') }}</th>
                            <th>{{ trans('messages.tbl_name') }}</th>
                            <th>{{ trans('messages.lbl_opening_hours') }}</th>
                            <th>{{ trans('messages.tbl_created_date') }}</th>
                            <th>{{ trans('messages.tbl_img') }}</th>
                            <th>{{ trans('messages.tbl_options') }}</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse($shops as $key => $shop)
                          <tr>
                            <td class="text-center">{{ ($shops->currentpage()-1) * $shops->perpage() + $key + 1  }}</td>
                            <td>{{ $shop->name }}</td>
                            <td>
                              
                              {{ \Carbon\Carbon::parse($shop->starttime)->format('H:i')}}時
                               ～ 
                              {{ \Carbon\Carbon::parse($shop->endtime)->format('H:i')}}時
                            </td>
                            <td>{{ $shop->created_at->format('Y M d') }}</td>
                            <td>
                              @if($shop->image)
                              <img src="{{ URL::asset('resources/assets/uploads/'.$shop->image) }}" width="40">
                              @endif
                            </td>
                            <td><!-- <a href="{{url('/admin/shop/edit',$shop->id)}}" alt="Edit">
                              <i class="mdi mdi-pencil"></i>
                            </a> -->
                            <a href="{{url('/admin/shop/'.$shop->id.'/edit')}}" alt="Edit">
                              <i class="mdi mdi-pencil" style="font-size: 25px;color: orange"></i>
                            </a>
                            @if($shop->validflg)
                            <a href="javascript:mkvalidInvalid('{{$shop->id}}',0)" alt="Edit">
                              <i class="mdi mdi-check-circle" style="font-size: 25px;color: green"></i>
                            </a>
                            @else
                            <a href="javascript:mkvalidInvalid('{{$shop->id}}',1)" alt="Edit">
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
                  </div>
                </div>{{ $shops->links() }}
              </div>

            </div>
          </div>
          <form id="validstatuschangefrm" method="post" action="{{route('admin.shop.mkinvalid.submit')}}">
            @csrf
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="validflg" id="validflg">
          </form>
    <!--  -->
  </div>
@endsection