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
				 ucwords($terapi->signa) !== ucwords('puyer' )
				 && ucwords($terapi->signa) !== ucwords( 'add')
				 {{-- // jika spuit --}}
				 && !str_contains( ucwords($terapi->merek->merek),  ucwords('spuit'))
				 {{-- // jika hanskun --}}
				 && !str_contains( ucwords($terapi->merek->merek),  ucwords('hands coon'))
				 {{-- // jika krim / salep --}}
				 {{-- && ucwords($terapi->merek->rak->formula) !== ucwords( 'salep') --}}
				)
				<table width="100% text-center">
					<tr>
						<td colspan="2" class="h1 underline text-center">{{ \Auth::user()->tenant->name }}</td>
					</tr>
					<tr class="font-small text-center">
                        <td>{{ !is_null( $periksa->tanggal )?\Carbon\Carbon::parse($periksa->tanggal)->format('d M Y'):'' }} {{ $periksa->jam_periksa }}</td>
						<td>{{ $periksa->id }}</td>
					</tr>
					<tr>
						<td colspan="2" class="text-center">{{ ucwords($printed_nama) }} ({{ $periksa->pasien->usia }} th)</td>
					</tr>
					<tr>
						<td colspan="2" class="text-center">{{ $terapi->merek->merek }} ({{ $terapi->jumlah }})</td>
					</tr>
					<tr>
						<td colspan="2" class="h1 text-center">{{ trim( $terapi->signa ) }}</td>
					</tr>
					<tr>
						<td colspan="2" class="aturan_minum text-center">{{ trim( $terapi->aturan_minum ) }}</td>
					</tr>
					<tr>
                        <td colspan="2" class="aturan_minum text-center">
                            @if( $terapi->merek->rak->formula->cunam->cunam == 4 )

                            @else
                                {{ $terapi->merek->rak->formula->cunam? $terapi->merek->rak->formula->cunam->cunam : 'Sebelum/Diantara/Sesudah makan' }}
                            @endif
                        </td>
					</tr>
                    @if( !is_null( $terapi->exp_date ) )
                    <tr>
                        <td colspan="2" class="aturan_minum text-center"> exp date : {{ $terapi->exp_date->format('d M Y') }}</td>
					</tr>
                    @endif
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
