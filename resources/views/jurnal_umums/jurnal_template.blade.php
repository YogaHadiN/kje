<div style="overflow-x:auto">
	<table class="table borderless table-condensed">
		<thead>
			<tr>
				<th>Tanggall</th>
				<th>Akun </th>
				<th>Debet</th>
				<th>Kredit</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@if (count($jurnalumums) > 0)
			@foreach($jurnalumums as $k=>$ju)
				 @foreach($ju->jurnalable_type::find($ju->jurnalable_id)->jurnals as $ky=>$jur)
					@if($jur->debit == '1' && $ky == 0)
					<tr class="b-top">
					  <td rowspan="{{$ju->jurnalable_type::find($ju->jurnalable_id)->jurnals->count()}}">{!!$jur->tanggal!!} <br>
						  {{ $ju->created_at->format('H:i:s') }} <br />
					   - {{ $ju->jurnalable_type}} {{ $ju->jurnalable_id}}
					  @if($ju->jurnalable_type == 'App\Models\Periksa')
						<br>
					   - Pembayaran : {{ $ju->jurnalable_type::find($ju->jurnalable_id)->asuransi->nama}}
					  @endif
					  </td>
					  <td>
						@if(!empty($jur->coa_id))
						  {!! $jur->coa_id!!} - {!!$jur->coa->coa!!}
						@endif
					  </td>
					  <td class="uang">{!!$jur->nilai!!}</td>
					  <td></td>
					  <td>
					  @if($ju->jurnalable_type == 'App\Models\Periksa')
						  <a href="{{ url('periksas/' . $ju->jurnalable_id)}}" class="btn btn-primary btn-xs btn-block">Detail</a> 
					  @elseif($ju->jurnalable_type == 'App\Models\FakturBelanja' && $ju->jurnalable_type::find($ju->jurnalable_id)->belanja_id == '1')
						  <a href="{{ url('pembelians/show/' . $ju->jurnalable_id)}}" class="btn btn-primary btn-xs btn-block">Detail</a> 
					  @elseif($ju->jurnalable_type == 'App\Models\FakturBelanja'&& $ju->jurnalable_type::find($ju->jurnalable_id)->belanja_id == '3')
						  <a href="{{ url('pengeluarans/show/' . $ju->jurnalable_id) }}" class="btn btn-primary btn-xs btn-block">Detail</a> 
					  @elseif($ju->jurnalable_type == 'App\Models\NotaJual'&& $ju->jurnalable_type::find($ju->jurnalable_id)->pembayaranAsuransi->count() > '0')
						  <a href="{{ url('pendapatans/pembayaran/asuransi/show/' . $ju->jurnalable_id) }}" class="btn btn-primary btn-xs btn-block">Detail</a> 
					  @endif
					  <a class="btn btn-xs btn-block btn-warning" href="{{ url('jurnal_umums/'. $ju->id . '/edit') }}">Edit</a>
					  </td>
					</tr>
					 @elseif($jur->debit == '1' && $ky != 0)
					   <tr>
						<td>
						  @if(!empty($jur->coa_id))
							{!! $jur->coa_id!!} - {!!$jur->coa->coa!!}
						  @endif
						</td>
						<td class="uang">{!!$jur->nilai!!}</td>
						<td></td>
						<td></td>
					  </tr>
					 @elseif($jur->debit == '0' && $ky != ($ju->jurnalable_type::find($ju->jurnalable_id)->jurnals)->count()-1)
					 <tr>
						<td class="text-right">
						  @if(!empty($jur->coa_id))
							{!! $jur->coa_id!!} - {!!$jur->coa->coa!!}
						  @endif
						</td>
						<td></td>
						<td class="uang">{!!$jur->nilai!!}</td>
						<td></td>
					</tr>
					@else 
					 <tr class="b-bottom">
						<td class="text-right">
						  @if(!empty($jur->coa_id))
							{!! $jur->coa_id!!} - {!!$jur->coa->coa!!} <br>
							{!! App\Models\Classes\Yoga::Flash($jur->jurnalable->ketjurnal) !!}
						  @endif
						</td>
						<td></td>
						<td class="uang">{!!$jur->nilai!!}</td>
						<td></td>
					</tr>
					@endif
				  </tr>
				@endforeach
			@endforeach
			@else
			<tr>
			  <td colspan="7" class="text-center">Tidak ada Data Untuk Ditampilkan :p</td>
			</tr>
			@endif
		</tbody>
	</table>
<div>
