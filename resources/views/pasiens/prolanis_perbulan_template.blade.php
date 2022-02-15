<div class="table-responsive">
	<table class="table table-hover table-condensed table-bordered DTa">
		<thead>
			<tr>
				<th>No</th>
				<th>Tanggal</th>
				<th>Nama</th>
				<th>Nomor Telpon</th>
				<th>Nomor Asuransi</th>
				<th>Tanggal Lahir</th>
				<th>Usia</th>
				<th>Alamat</th>
				<th>Tekanan Darah</th>
				<th>Gula Darah</th>
			</tr>
		</thead>
		<tbody>
			@if(count($$prolanis) > 0)
				@php
					$i = 1
				@endphp
				@foreach($$prolanis as $p)
					<tr
						@if (
							tekananDarahTerkendali( 
								 \App\Models\Classes\Yoga::umurSaatPeriksa($p['tanggal_lahir'], $p['tanggal']), 
								 $p['tekanan_darah']['sistolik'], 
								 $p['tekanan_darah']['diastolik']
							 )
						)
						class="success"
						@endif
						>
						<td>{{ $i++ }}</td>
						<td>
							@if (isset($bukan_pdf))
								<a href="{{ url('periksas/' . $p['periksa_id'] ) }}" target="_blank">{{ $p['tanggal'] }}</a>
							@else
								{{ $p['tanggal'] }}
							@endif
						</td>
						<td
							@if(is_null( $p['prolanis_ht_flagging_image'] ))
								class="danger"
							@endif
							>
							@if (isset($bukan_pdf))
								<a href="{{ url('pasiens/' . $p['pasien_id'] . '/edit') }}" target="_blank">{{ ucwords($p['nama']) }}</a>
							@else
								{{ ucwords($p['nama']) }}		
							@endif
						</td>
						<td>{{ $p['nomor_asuransi_bpjs'] }}</td>
						<td>{{ $p['no_telp'] }}</td>
						<td>{{ $p['tanggal_lahir'] }}</td>
						<td>{{ App\Models\Classes\Yoga::umurSaatPeriksa($p['tanggal_lahir'], $p['tanggal']) }}</td>
						<td>{{ $p['alamat'] }}</td>
						<td nowrap>
								{{ $p['tekanan_darah']['sistolik'] }} / {{ $p['tekanan_darah']['diastolik'] }} mmHg
						</td>
						<td>
							@if( isset( $p['gula_darah'] ) )
								{{ $p['gula_darah'] }}
							@endif
						</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="4" class="text-center">Tidak ada data </td>
				</tr>
			@endif
		</tbody>
	</table>
</div>
