<div>{{$slot}}
    @if(session()->has('message'))
	  <div class="alret alert-success">{{ session()->get('message') }}</div>
	@elseif(session()->has('error'))
	  <div class="alret alert-danger">{{ session()->get('error') }}</div>
	@endif
</div>