<div class="table-responsive">
	<table class="table table-hover table-condensed table-bordered DT">
		<thead>
			<tr>
				<th>Nama</th>
				<th>Alamat</th>
				<th>Tanggal Lahir</th>
				<th>No Telp</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@if(count($pasiens) > 0)
				@foreach($pasiens as $p)
					<tr>
						<td>{{ $p->nama }}</td>
						<td>{{ $p->alamat }}</td>
						<td>{{ $p->tanggal_lahir }}</td>
						<td>{{ $p->no_telp }}</td>
						<td nowrap class="autofit">
							<a href="{{ url('pasiens/' . $p->id) }}" target="_blank">Riwayat Pasien</a>
						</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="5" class="text-center">Tidak ada data untuk ditampilkan</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>
