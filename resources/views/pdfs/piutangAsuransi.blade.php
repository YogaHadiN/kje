<html>
<head>
	<meta charset="UTF-8">
	<title>{{ ucwords( \Auth::user()->tenant->name ) }} | Piutang Asuransi </title>
    <link rel="stylesheet" href="{{ url('css/struk.css') }}" title="" type="" />
</head>
<body>
    <table id="header">
        <tr>
            <td class="text-center">
                <div class="klinik">{{ \Auth::user()->tenant->name }} </div>
                <div class="title">
                    Jl. Raya Legok - Parung Panjang km. 3, <br>
                    Malangnengah, Pagedangan, Tangerang, Banten 021 5977529
                </div>
            </td>
        </tr>
    </table>
<hr />
	<h1>Asuransi {{ $asuransi->nama }} (Update tanggal {{ date('d F Y') }})</h1>
	<h3> Piutang  {{ date('d M y', strtotime( $mulai )) }} sampai {{ date('d M y', strtotime( $akhir )) }} ({{ count( $piutangs ) }} pasien)</h3>

		<table class="table text3">
			<thead>
				<tr>
					<th>Tanggal Periksa</th>
					<th>ID PERIKSA</th>
					<th>Nama</th>
					<th>Tunai</th>
					<th>Piutang</th>
					{{-- <th>Sudah Dibayar</th> --}}
					{{-- <th>Sisa Piutang</th> --}}
				</tr>
			</thead>
			<tbody>
				@if(count($piutangs) > 0)
					@foreach($piutangs as $p)
						<tr>
							<td>{{ date('d M y', strtotime( $p->tanggal_periksa )) }}</td>
							<td> {{ $p->periksa_id }}</td>
							<td> {{ $p->nama_pasien }}</td>
							<td class="text-right"> {{ App\Models\Classes\Yoga::buatrp($p->tunai) }}</td>
							<td class="text-right"> {{ App\Models\Classes\Yoga::buatrp($p->piutang) }}</td>
							{{-- <td class="text-right"> {{ App\Models\Classes\Yoga::buatrp($p->sudah_dibayar) }}</td> --}}
							{{-- <td class="text-right"> {{ App\Models\Classes\Yoga::buatrp($p->piutang  - $p->sudah_dibayar) }}</td> --}}
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="6" class="text-center">Tidak ada data untuk ditampilkan</td>
					</tr>
				@endif
				<tr>
					<td colspan="3"></td>
					<td class="text-right">
						<h2> {{ App\Models\Classes\Yoga::buatrp( $total_tunai ) }}</h2>
					</td>
					<td class="text-right">
						<h2> {{ App\Models\Classes\Yoga::buatrp( $total_piutang ) }}</h2>
					</td>
					{{-- <td class="text-right"> --}}
					{{-- 	<h2> {{ App\Models\Classes\Yoga::buatrp( $total_sudah_dibayar ) }}</h2> --}}
					{{-- </td> --}}
					{{-- <td class="text-right"> --}}
					{{-- 	<h2> {{ App\Models\Classes\Yoga::buatrp( $total_piutang - $total_sudah_dibayar ) }}</h2> --}}
					{{-- </td> --}}
				</tr>
			</tbody>


		</table>
</body>
</html>
