<div class="table-responsive">
	<table class="table table-hover table-condensed table-bordered">
		<thead>
			<tr>
				<th rowspan="2">Peralatan</th>
				<th rowspan="2">Bulan Perolehan</th>
				<th rowspan="2">Harga Perolehan</th>
				<th rowspan="2">Nilai Buku Fiskal <br /> Awal Tahun	</th>
				<th colspan="2">Metode Penyusutan</th>
				<th rowspan="2">Penyusutan / <br /> Amortisasi Tahun Ini</th>
				<th rowspan="2">Catatan</th>
			</tr>
			<tr>
				<th>Komersial</th>
				<th>Fiskal</th>
			</tr>
		</thead>
		<tbody>
			@if(count($peralatans) > 0)
				@foreach( $peralatans as $p )
					<tr>
						<td>{{ $p->peralatan }} <br /> {{ $p->jumlah }} unit</td>
						<td>{{ $p->tanggal_perolehan }}</td>
						<td nowrap class="text-right">{{$p->jumlah * $p->harga_satuan }}</td>
						<td nowrap class="text-right">{{$p->jumlah * $p->harga_satuan - $p->susut_fiskal_tahun_lalu }}</td>
						<td nowrap class="text-center">GL</td>
						<td nowrap class="text-center">GL</td>
						<td nowrap class="text-right">{{$p->total_penyusutan - $p->susut_fiskal_tahun_lalu }}</td>
						<td nowrap class="text-right"></td>
					</tr>
				@endforeach
			@else
				<tr>
					<td class="text-center" colspan="5">Tidak ada data untuk ditampilkan</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>
