		<table class="table borderless table-condensed">
			<thead>
				<tr>
					<th>Akun </th>
					<th>Debet</th>
					<th>Kredit</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				  @if (count($periksa->jurnals) > 0)
					@foreach($periksa->jurnals as $k=>$jur)
						@if($jur->debit == 1)
						   <tr>
							   <td>{!! $jur->coa->coa !!}</td>
							   <td class="uang">{!! $jur->nilai!!}</td>
							   <td></td>
							   <td> 
								   <a 
									  @if( \Auth::id() != '28' )
										disabled	
									  @endif
								   class="btn btn-warning btn-xs btn-block" href="{{ url('jurnal_umums/'. $jur->id . '/edit') }}">Edit</a> </td>
							   </td>
						   </tr> 
						   @else
							<tr>
							   <td class="text-right">{!! $jur->coa->coa !!}</td>
							   <td></td>
							   <td class="uang">{!! $jur->nilai!!}</td>
							   <td> 
								   <a 
									  @if( \Auth::id() != '28' )
										disabled	
									  @endif
								   class="btn btn-warning btn-xs btn-block" href="{{ url('jurnal_umums/'. $jur->id . '/edit') }}">Edit</a> </td>
							</tr>
						@endif
					@endforeach
				  @else
					<tr>
					  <td colspan="
					  @if( \Auth::id() == '28' )
					  	  8
					  @else
						  7
					  @endif
						  " class="text-center">Tidak ada Data Untuk Ditampilkan :p</td>
					</tr>
				  @endif
			</tbody>
		</table>
