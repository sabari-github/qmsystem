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
              <a href="{{ url('admin/') }}">{{ trans('messages.lbl_queue') }}</a>
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
                  <p class="grid-header">{{ trans('messages.lbl_queue_details') }}</p>
                  <div class="item-wrapper">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th class="text-center">{{ trans('messages.tbl_no') }}</th>
                            <th>{{ trans('messages.tbl_date') }}</th>
                            <th>{{ trans('messages.tbl_queue_no') }}</th>
                            <th>{{ trans('messages.tbl_queue_time') }}</th>
                            <th>{{ trans('messages.lnk_service') }}</th>
                            <th>{{ trans('messages.lbl_shop') }}</th>
                            <th>{{ trans('messages.tbl_status') }}</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse($queues as $key => $queue)
                          <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>{{ $queue['queuedate'] }}</td>
                            <td>{{ $queue['token_number'] }}</td>
                            <td>
                              {{ $queue['queue_time'] }}
                            </td>
                            <td>{{ $queue['servicename'] }}</td>
                            <td>{{ $queue['shopname'] }}</td>
                            <td>{{ $queue['service_status'] }}</td>
                          </tr>
                          @empty
                            <tr>
                              <td colspan="8" style="text-align: center;">{{ trans('messages.tbl_no_queue_data') }}</td>
                            </tr>
                          @endforelse
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
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