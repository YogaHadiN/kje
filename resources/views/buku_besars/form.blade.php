<div class="table-responsive">
		<table class="table table-bordered" id="table_buku_besar">
			<thead class="text-center light-bold">
			  <tr>
				<th rowspan="2">No</th>
				<th rowspan="2">Tanggal</th>
				<th rowspan="2">Penjelasan</th>
				<th rowspan="2">Debet</th>
				<th rowspan="2">Kredit</th>
				<th colspan="2">Saldo</th>
				<th rowspan="2">Action</th>
			  </tr>
			  <tr>
				<th>Debet</th>
				<th>Kredit</th>
			  </tr>
			</thead>
			<tbody>
				@if( $jurnalumums->count() > 0 )
					  @foreach($jurnalumums as $k => $ju)
					  <tr>
						<td nowrap>{{ $k + 1}}</td>
						<td>{{ $ju->tanggal }} <br /> {{ $ju->id }} </td>
						<td>{!! $ju->jurnalable->ketjurnal !!}</td>
						@if($ju->debit == 1)
						<td class="uang">
						  {{ $ju->nilai }}
						@else
						<td>
						@endif
						</td>
						@if($ju->debit == 0)
						<td class="uang">
						  {{ $ju->nilai }}
						@else
						<td>
						@endif
						</td>
						@if(App\Models\Classes\Yoga::bukuBesarDebit($jurnalumums, $k) > 0)
						<td class="uang">
						  {{ App\Models\Classes\Yoga::bukuBesarDebit($jurnalumums, $k)}}
						@else
						<td>
						@endif
						</td>
						@if(App\Models\Classes\Yoga::bukuBesarKredit($jurnalumums, $k) > 0)
						<td class="uang">
						  {{ App\Models\Classes\Yoga::bukuBesarKredit($jurnalumums, $k)}}
						@else
						<td>
						@endif
						</td>
						<td> <a class="btn btn-success btn-xs" href="{{ url('jurnal_umums/' . $ju->id . '/edit' ) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> </td>
					  </tr>
					  @endforeach
				@else
					<tr>
						<td colspan="8" class="text-center">Tidak ada data untuk ditampilkan :p</td>
					</tr>
				@endif
			</tbody>
		  </table>
</div>
    
