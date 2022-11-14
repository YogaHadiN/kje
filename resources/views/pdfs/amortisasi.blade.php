<html>
<head>
	<meta charset="UTF-8">
	<title>{{ ucwords( \Auth::user()->tenant->name ) }} | Status</title>
    <link href="{!! asset('css/jurnal.css') !!}" rel="stylesheet">
</head>
<body style="font-size:11px; font-family:sans-serif">

	<div class="text-center">
		<h1>LAMPIRAN KHUSUS</h1>
		<h2>SPT TAHUNAN PAJAK PENGHASILAN WAJIB PAJAK BADAN</h2>
		<h2>TAHUN PAJAK {{ $tahun }}</h2>
		<h2>DAFTAR PENYUSUTAN DAN AMORTISASI FISKAL</h2>
	</div>
	<table class="no_border">
		<h4>
			<tbody>
				<tr>
					<td class="text-left">NPWP : {{  env("NPWP")  }}</td>
					<td class="text-right">NAMA WAJIB PAJAK : {{ ucwords( \Auth::user()->tenant->name ) }}</td>
				</tr>
			</tbody>
		</h4>
	</table>
	<div class="table-responsive">
		<table class="table table-hover table-condensed table-custom-bordered">
			<thead>
				<tr class="border-top">
					<th rowspan="2" colspan="2">Peralatan</th>
					<th rowspan="2">Bulan Perolehan</th>
					<th rowspan="2">Harga Perolehan</th>
					<th rowspan="2">Nilai Buku Fiskal <br /> Awal Tahun	</th>
					<th colspan="2" class="border-bottom">Metode Penyusutan</th>
					<th rowspan="2">Penyusutan / <br /> Amortisasi Tahun Ini</th>
					<th rowspan="2">Catatan</th>
				</tr>
				<tr class="border-bottom">
					<th>Komersial</th>
					<th>Fiskal</th>
				</tr>
			</thead>
			<tbody>
					<tr>
						<td colspan="2">HARTA BERWUJUD</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					@include('pdfs.formAmortisasi', [
						'kelompok' => 'Kelompok I',
						'peralatans' => $peralatans[4]
					])
					@include('pdfs.formAmortisasi', [
						'kelompok' => 'Kelompok II',
						'peralatans' => $peralatans[8]
					])
					@include('pdfs.formAmortisasi', [
						'kelompok' => 'Kelompok III',
						'peralatans' => $peralatans[16]
					])
					@include('pdfs.formAmortisasi', [
						'kelompok' => 'Kelompok IV',
						'peralatans' => $peralatans[20]
					])
					<tr>
						<td colspan="2">	
							KELOMPOK BANGUNAN
						</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					@include('pdfs.formAmortisasi', [
						'kelompok' => 'Bangunan Permanen',
						'peralatans' => $bahan_bangunans[1]
					])
					@include('pdfs.formAmortisasi', [
						'kelompok' => 'Tidak Permanen',
						'peralatans' => $bahan_bangunans[0]
					])
					<tr class="border-top">
						<td colspan="7">JUMLAH PENYUSUTAN FISKAL</td>
						<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $jumlah_penyusutan )}}</td>
						<td></td>
					</tr>
					<tr>
						<td colspan="7">JUMLAH PENYUSUTAN KOMERSIAL</td>
						<td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $jumlah_penyusutan )}}</td>
						<td></td>
					</tr>
					<tr>
						<td class="border-bottom" colspan="7">SELISIH PENYUSUTAN</td>
						<td class="border-bottom text-right">{{ App\Models\Classes\Yoga::buatrp(0) }}</td>
						<td class="border-bottom"></td>
					</tr>
					<tr>
						<td colspan="2">	
							HARTA TAK BERWUJUD
						</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					@include('pdfs.formAmortisasi', [
						'kelompok' => 'Kelompok I',
						'peralatans' => []
					])
					@include('pdfs.formAmortisasi', [
						'kelompok' => 'Kelompok II',
						'peralatans' => []
					])
					@include('pdfs.formAmortisasi', [
						'kelompok' => 'Kelompok III',
						'peralatans' => []
					])
					@include('pdfs.formAmortisasi', [
						'kelompok' => 'Kelompok IV',
						'peralatans' => []
					])
					<tr class="border-top">
						<td colspan="7">JUMLAH PENYUSUTAN FISKAL</td>
						<td class="text-right">{{ App\Models\Classes\Yoga::buatrp(0)}}</td>
						<td></td>
					</tr>
					<tr>
						<td colspan="7">JUMLAH PENYUSUTAN KOMERSIAL</td>
						<td class="text-right">{{App\Models\Classes\Yoga::buatrp(0)}}</td>
						<td></td>
					</tr>
					<tr>
						<td colspan="7">SELISIH PENYUSUTAN</td>
						<td class="text-right">{{ App\Models\Classes\Yoga::buatrp(0) }}</td>
						<td></td>
					</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="7"></td>
					<td colspan="2"></td>
				</tr>
			</tfoot>
		</table>
	</div>
</body>
</html>
