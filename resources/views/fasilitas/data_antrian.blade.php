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
		@if (isset($antrian->alamat))
			<tr>
				<td nowrap>Alamat</td>
				<td nowrap>{{ $antrian->alamat }}</td>
			</tr>
		@endif
		@if (isset($antrian->registrasi_pembayaran_id))
			<tr>
				<td nowrap>Pembayaran</td>
                <td nowrap>{{ $antrian->registrasi_pembayaran->registrasi_pembayaran }}</td>
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
