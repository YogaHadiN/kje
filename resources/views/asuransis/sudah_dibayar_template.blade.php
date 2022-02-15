<div class="table-responsive">
	<table class="table table-hover table-condensed table-bordered">
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Nama</th>
				<th>Tunai</th>
				<th>Piutang</th>
				<th>Sudah dibayar</th>
			</tr>
		</thead>
		<tbody>
			@if(count($sudah_dibayars) > 0)
				@foreach($sudah_dibayars as $sudah)
					<tr>
						<td>{{ date('d M y', strtotime( $sudah->tanggal )) }}</td>
						<td>
							<a class="" href="{{ url('periksas/' . $sudah->periksa_id) }}">
								{{ $sudah->nama_pasien }}
							</a>
						</td>
						<td class="text-right"> {{ App\Models\Classes\Yoga::buatrp($sudah->tunai) }}</td>
						<td class="text-right"> {{ App\Models\Classes\Yoga::buatrp($sudah->piutang) }}</td>
						<td class="text-right"> {{ App\Models\Classes\Yoga::buatrp($sudah->sudah_dibayar) }}</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="5" class="text-center">Tidak ada data untuk ditampilkan</td>
				</tr>
			@endif
		</tbody>
		<tfoot>
			<tr>
				<td colspan="2"></td>
				<td class="text-right">
					<h2> {{ App\Models\Classes\Yoga::buatrp( $total_tunai ) }}</h2>
				</td>
				<td class="text-right">
					<h2> {{ App\Models\Classes\Yoga::buatrp( $total_piutang ) }}</h2>
				</td>
				<td class="text-right">
					<h2> {{ App\Models\Classes\Yoga::buatrp( $total_sudah_dibayar ) }}</h2>
				</td>
			</tr>
		</tfoot>
	</table>
</div>
