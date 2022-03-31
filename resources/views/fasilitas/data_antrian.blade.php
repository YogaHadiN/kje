<div class="table-responsive">
	<table class="full-width small table table-condensed table-bordered">
	<tbody>
		@if (isset($antrian->nama))
			<tr>
				<td nowrap>Nama</td>
				<td nowrap>{{ $antrian->nama }}</td>
			</tr>
		@endif
		@if (isset($antrian->tanggal_lahir))
			<tr>
				<td nowrap>Tanggal Lahir</td>
				<td nowrap>{{ $antrian->tanggal_lahir->format('Y-m-d') }}</td>
			</tr>
		@endif
		@if (isset($antrian->nama_asuransi))
			<tr>
				<td nowrap>Pembayaran</td>
				<td nowrap>{{ $antrian->nama_asuransi }}</td>
			</tr>
		@endif
		@if (isset($antrian->nomor_asuransi))
			<tr>
				<td nowrap>Nomor Asuransi</td>
				<td nowrap>{{ $antrian->nomor_asuransi }}</td>
			</tr>
		@endif
	</tbody>
</table>
</div>
