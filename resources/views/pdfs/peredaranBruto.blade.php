<html>
<head>
	<meta charset="UTF-8">
	<title>{{ ucwords( \Auth::user()->tenant->name ) }} | Status</title>
    <link href="{!! asset('css/jurnal.css') !!}" rel="stylesheet">
	<style type="text/css" media="all">
		tfoot td{

			border : 0.5px solid black;

		}
		table th, table td {
			line-height : 20px;
		}
	</style>
</head>
<body style="font-size:11px; font-family:sans-serif">
	<div class="text-center">
		<h1>LAMPIRAN KHUSUS</h1>
		<h2>SPT TAHUNAN PAJAK PENGHASILAN WAJIB PAJAK BADAN</h2>
		<h2>TAHUN PAJAK {{ date('Y') - 1 }}</h2>
		<h2>PEREDARAN BRUTO</h2>
	</div>
	<br />	
	<table style="font-size:15px" class="no_border">
		<h4>
			<tbody>
				<tr>
					<td class="text-left">NPWP : {{  env("NPWP")  }}</td>
					<td class="text-right">NAMA WAJIB PAJAK : {{ ucwords( \Auth::user()->tenant->name ) }}</td>
				</tr>
			</tbody>
		</h4>
	</table>
	<table style="font-size:15px">
		<thead>
			<tr>
				<th>Bulan</th>
				<th>Peredaran Bruto</th>
			</tr>
		</thead>
		<tbody>
			@foreach( $peredaranBruto as $p )
				<tr>
					<td>{{ $p->bulan }}</td>
					<td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $p->total  )}}</td>
				</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<td>Total</td>
				<td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $total  )}}</td>
			</tr>
		</tfoot>
	</table>
</body>
</html>
