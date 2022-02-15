<table id="header">
		<tr>
			<td class="text-center border-bottom" colspan="3">
				<div class="klinik">Surat Keterangan Pemeriksaan</div>
				<div class="title">
					Nomor Surat : {{ $periksa->id }}/{{ $antigen? 'Antigen' : 'Antibodi' }} CoV-19/KJE/{{ App\Models\Classes\Yoga::numberToRomanRepresentation(date('m')) }}/{{ date('Y') }}
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="3"></td>
		</tr>
		<tr>
			<td>Dengan ini menyatakan bahwa </td>
		</tr>
		<tr>
			<td>Nama / <i>Name</i></td>
			<td>:</td>
			<td> {{ strtoupper($periksa->pasien->nama) }}</td>
		</tr>
		<tr>
			<td>Nomor Identitas / <i>Identity Number</i></td>
			<td>:</td>
			<td> {{ strtoupper($periksa->pasien->nomor_ktp) }}</td>
		</tr>
		<tr>
			<td>Jenis Kelamin / <i>Gender</i></td>
			<td>:</td>
			<td> {{ strtoupper($periksa->pasien->sex == '1'? 'Laki-laki' : 'Perempuan') }}</td>
		</tr>
		<tr>
			<td>Tanggal Lahir / <i>Date of birth</i></td>
			<td>:</td>
			<td> {{ strtoupper($periksa->pasien->tanggal_lahir->format('d M Y')) }}</td>
		</tr>
		<tr>
			<td>Alamat / <i>Address</i></td>
			<td>:</td>
			<td> {{ strtoupper($periksa->pasien->alamat) }}</td>
		</tr>
		<tr>
			<td>No Telepon / <i>Phone Number</i></td>
			<td>:</td>
			<td> {{ strtoupper($periksa->pasien->no_telp) }}</td>
		</tr>
		<tr>
			<td>Waktu Pemeriksaan / <i>Examination Time</i></td>
			<td>:</td>
			<td> {{ $periksa->created_at->format('d/m/Y') }} JAM  {{ $periksa->created_at->format('H:i') }} WIB</td>
		</tr>
		<tr>
			<td>Hasil Pemeriksaan / <i>Examination Result</i></td>
			<td>:</td>
			<td> {{ $hasil }}
				<br>
					Terhadap Rapid Test {{ $antigen ? 'Antigen' : 'Antibodi' }} SARS-Cov2
			</td>
		</tr>
		<tr>
			<td colspan="3">Demikian Surat Hasil Pemeriksaan ini dibuat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya.</td>
		</tr>
	</table>
