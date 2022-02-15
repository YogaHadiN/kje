<style type="text/css" media="screen">
	.btn.disabled {
		pointer-events: auto;
	}
</style>
<button type="button"
	class="btn btn-info 
	@if ( isset($bigger_button) )
		btn-sm
	@else
		btn-xs
	@endif
		@if( !$antrian->is_today )
			disabled		
		@endif
	" 
		@if( !$antrian->is_today )
			 data-toggle="tooltip" data-placement="bottom" title="Bukan antrian hari ini"
		@endif
	onclick="panggil('{{ $antrian->id }}', 'pendaftaran');return false;">
	  <span class="glyphicon glyphicon-volume-up" aria-hidden="true"></span>
</button>
