<html>
<head>
	<meta charset="UTF-8">
	<title>{{ env("NAMA_KLINIK") }} | Label Obat</title>
<style>
	*{
		margin: 0;
		padding: 0;
	}
	@page 
	{
		font-family: "Lucida Console", "Courier New", monospace;
    }
	.font-smaller {
	  font-size: 15px;
	}
	.text-center {
		text-align: center;
	}
	.h1  {
		font-size: 20px;
			font-weight: bold;
	}
	table {
		margin: 0;
		padding: 0;
		font-family: "Lucida Console", "Courier New", monospace;
        page-break-inside: avoid;
		font-size: 14px;
	}
	.underline {
		border-bottom: 1px solid black;
	}
	.h2 {
		font-size: 20px;
	}
</style>
</head>
<body style="font-size:11px; font-family:sans-serif">
	<div style="" class="klinik">
		@foreach ($periksa->terapii as $k => $terapi)
			@if (
				 ucwords($terapi->signa) !== ucwords('puyer' ) &&
				 ucwords($terapi->signa) !== ucwords( 'add')
				)
				<table width="100% text-center">
					<tr>
						<td colspan="2" class="h1 underline text-center">Klinik Jati Elok</td>
					</tr>
					<tr class="font-small text-center">
						<td>{{ \Carbon\Carbon::parse( $periksa->tanggal )->format('d M Y') }} {{ $periksa->jam_periksa }}</td>
						<td>{{ $periksa->id }}</td>
					</tr>
					<tr>
						<td colspan="2" class="h2 text-center">{{ $printed_nama }}</td>
					</tr>
					<tr>
						<td colspan="2" class="text-center">{{ $terapi->merek->merek }} ({{ $terapi->jumlah }})</td>
					</tr>
					<tr>
						<td colspan="2" class="h1 text-center">{{ $terapi->signa }}</td>
					</tr>
					<tr>
						<td colspan="2" class="aturan_minum text-center">{{ $terapi->aturan_minum }}</td>
					</tr>
					<tr>
						<td colspan="2" class="aturan_minum text-center">Sebelum/Diantara/Sesudah makan</td>
					</tr>
				</table>
				@if (
					(int)$k !== (int) (count($periksa->terapii) -1)
				)
					<div style="page-break-after:always;">
					</div>
				@endif
			@endif
		@endforeach
	</div>
    <script type="text/javascript" charset="utf-8">
        window.print();
    </script>
</body>
</html>
