<table class="table table-bordered table-hover" id="tableAsuransi">
	  <thead>
		<tr>
			<th class="id hide">id</th>
			<th>Antrian</th>
			<th>Asuransi</th>
			<th>Pasien</th>
			<th>Poli</th>
			<th>Jam</th>
			<th>Tanggal</th>
			<th class="displayNone">poli</th>
			<th class="displayNone">pasien_id</th>
			<th class="displayNone">staf_id</th>
			<th class="displayNone">asuransi_id</th>
			<th class="hide">image_url</th>
			<th class="hide">pengantar</th>
			<th class="hide">pasien_image</th>
			<th class="hide">ktp_image</th>
			<th class="hide">bpjs_image</th>
			<th class="hide">alamat</th>
			<th class="hide">No Asuransi</th>
			<th>Nama Asuransi</th>
			<th class="hide">Bukan Peserta</th>
			<th class="">Action</th>
		</tr>
	</thead>
	<tbody>
		@if (count($antrianpolis) > 0)
			@foreach ($antrianpolis as $antrianpoli)
				<tr
				  @if($antrianpoli->self_register == '1' && $antrianpoli->asuransi_id != 0)
					  class="danger"
				  @endif>
				<td class="hide id">{!! $antrianpoli->id !!}</td>
				<td class="antrian">{!! $antrianpoli->antrian!!}</td>
				<td class="nama">{!! $antrianpoli->asuransi->nama !!}</td>
				<td class="nama_pasien">{!! $antrianpoli->pasien->nama!!} </td>
				<td class="poli">{!! $antrianpoli->poli!!}</td>
				<td class="jam">{!! $antrianpoli->jam!!}</td>
				<td class="tanggal">{!! $antrianpoli->tanggal->format('d-m-Y')!!}</td>
				<td class="displayNone pasien_id">{!! $antrianpoli->pasien_id !!}</td>
			 	<td class="displayNone staf_id">{!! $antrianpoli->staf_id !!}</td>
				<td class="displayNone asuransi_id">{!! $antrianpoli->asuransi_id !!}</td>
				<td class="hide image">{!! $antrianpoli->pasien->image !!}?{{ time() }}</td>
				<td class="displayNone pengantar">{!! $antrianpoli->pengantar !!}</td>
				<td class="displayNone image image">{!! $antrianpoli->pasien->image !!}</td>
				<td class="displayNone ktp_image">{!! $antrianpoli->pasien->ktp_image !!}</td>
				<td class="displayNone bpjs_image">{!! $antrianpoli->pasien->bpjs_image !!}</td>
				<td class="displayNone alamat">{!! $antrianpoli->pasien->alamat !!}</td>
				<td class="displayNone tanggal_lahir">{!! $antrianpoli->pasien->tanggal_lahir !!}</td>
				<td class="displayNone nomor_asuransi">{!! $antrianpoli->pasien->nomor_asuransi!!}</td>
				<td class="nama_asuransi">{!! $antrianpoli->asuransi->nama !!}</td>
				<td class="displayNone bukan_peserta">{!! $antrianpoli->bukan_peserta !!}</td>
				<td nowrap>
					@if($antrianpoli->tanggal <= date('Y-m-d 00:00:00'))
						@if($antrianpoli->self_register == '1' && $antrianpoli->asuransi_id != 0)
							<a href=\"#\" class="btn btn-primary btn-xs btn-success" onclick="konfirmasiAsuransi(this);return false;" data-toggle="modal" data-target="#konfirmasiAsuransi">Konfirmasi</a>
						@else
							<a href=\"#\" class="btn btn-primary btn-xs" onclick="rowEntry(this);return false;" data-toggle="modal" data-target="#exampleModal">Proses</a>
						@endif
					@endif
						{!! Form::hidden('alasan', null, ['class' => 'alasan', 'id' => 'alasan_hapus' . $antrianpoli->id])!!}
						{!! Form::hidden('pasien_id', $antrianpoli->pasien_id, ['class' => 'form-control'])!!}
						<button type="button" class="btn btn-danger btn-xs" onclick="alas(this);return false;">Delete</button>

					@if($antrianpoli->tanggal <= date('Y-m-d 00:00:00'))
						@if($antrianpoli->antars->count() > 0 && $antrianpoli->asuransi_id == '32')
						<a href="{{ url('antrianpolis/pengantar/' . $antrianpoli->id . '/edit') }}" class="btn btn-success btn-xs">{{ $antrianpoli->antars->count() }} pengantar</a>		
						@elseif( $antrianpoli->asuransi_id == '32' )
						<a class="btn btn-warning btn-xs" href="{{ url('antrianpolis/pengantar/' . $antrianpoli->id . '/edit') }}">Edit Pengantar</a>
						@endif
					@endif
					{!! Form::open(['url' => 'antrianpolis/' . $antrianpoli->id, 'method' => 'delete', 'class' => 'right'])!!}
						{!! Form::submit('Delete', [
						'class' => 'btn btn-danger btn-xs hide submit', 
						'onclick' => 'return confirm("Anda yakin ingin menghapus pasien ' . $antrianpoli->id . ' - ' . $antrianpoli->pasien->nama . '")', 
						'id' => 'submitDelete' . $antrianpoli->id
						]) !!}
					{!! Form::close() !!}
				</td>
				<td class="hide umur">
					{!! App\Classes\Yoga::datediff($antrianpoli->pasien->tanggal_lahir, date('Y-m-d')) !!}
				</td>
			</tr>
			@endforeach
		@else 
		<tr>
			<td class="displayNone"></td>
			<td colspan="11" class="text-center">Tidak ada data untuk ditampilkan :p</td>
		</tr>
		@endif
	</tbody>
</table>
