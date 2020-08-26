@if(session()->has('message'))
  <div class="alret alert-success" style="text-align: center;">{{ session()->get('message') }}</div>
@elseif(session()->has('error'))
  <div class="alret alert-danger" style="text-align: center;">{{ session()->get('error') }}</div>
@endif