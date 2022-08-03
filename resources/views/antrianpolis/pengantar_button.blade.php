@if($antrianpoli->tanggal <= date('Y-m-d 00:00:00'))
    @if($tipe_asuransi_id == '5')
		<a href="{{ url($posisi_antrian . '/pengantar/' . $antrianpoli->id ) }}" class="btn btn-success btn-xs">{{ $antrianpoli->antars->count() }} pengantar</a>		
	@endif
@endif
