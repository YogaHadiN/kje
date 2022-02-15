<div class="table-responsive">
	<table class="table table-hover table-condensed table-bordered">
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Nama Pasien</th>
				<th>Nama Pemeriksa</th>
				<th>Pemeriksaan Fisik</th>
				<th>Pemeriksaan Penunjang</th>
				<th>Diagnosa</th>
			</tr>
		</thead>
		<tbody>
			@if(count($data) > 0)
				@foreach($data as $periksa)
					<tr>
						<td>{{ $periksa->tanggal_berobat }}</td>
						<td>{{ $periksa->nama_pasien }}</td>
						<td>{{ $periksa->nama_pemeriksa }}</td>
						<td>

							{{ $periksa->sistolik }} /
							{{ $periksa->diastolik }} mmHg <br />
							{{ $periksa->pf }}

						</td>
						<td>{{ $periksa->pj }}</td>
						<td>{{ $periksa->diagnosa }}</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="5" class="text-center"> Tidak ada data untuk ditampilkan </td>
				</tr>
			@endif
		</tbody>
	</table>
</div>
