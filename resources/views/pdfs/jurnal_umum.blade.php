<html>
<head>
	<meta charset="UTF-8">
	<title>{{ env("NAMA_KLINIK") }} | Status</title>
    <link href="{!! asset('css/jurnal.css') !!}" rel="stylesheet">
</head>
<body>
	<table class="table">
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Akun</th>
				<th>Debet</th>
				<th>Kredit</th>
			</tr>
		</thead>
		<tbody>
			@foreach($jurnals as $ju)	
				@foreach($ju as $k => $j)	
					@if( $k == 0 )
						<tr class="border-top">
						<td nowrap> {{ $j->created_at->format('d M Y H:i:s') }}</td>
					@elseif( $k == count($ju) -1 )
						<tr class="border-bottom">
							<td></td>	
					@else
						<tr>
							<td></td>	
					@endif
						@if( $j->debit == '1' )
							<td class='text-left'> {{ $j->coa->coa }}</td>
							<td nowrap class="text-right"> {{App\Models\Classes\Yoga::buatrp(  $j->nilai  )}}</td>
							<td></td>
							@if( $k == count($ju) -1 )
								<tr class="border-bottom">
									<td></td>	
							@else
								<tr>
									<td></td>	
							@endif
						@else
							<td class='text-right'> {{ $j->coa->coa }}</td>
							<td></td>
							<td nowrap class="text-right"> {{App\Models\Classes\Yoga::buatrp(  $j->nilai  )}}</td>
							@if( $k == count($ju) -1 )
								</tr>
								@if( isset( $j->jurnalable->ketJurnal ) )
								<tr>
									<td></td>
									<td>{!! $j->jurnalable->ketJurnal !!}</td>
									<td colspan="2"></td>
								</tr>
								@endif
							@else
								</tr>
							@endif
						@endif
				@endforeach
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<td colspan="4"></td>
			</tr>
		</tfoot>
	</table>
</body>
</html>
