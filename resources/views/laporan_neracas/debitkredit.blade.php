 @if($ju['debit'] - $ju['kredit'] != 0)
	<tr>
		<td></td>
		<td>{{ $ju['coa_id'] }}-{{$ju['coa'] }}</td>
		<td class="text-right">{{  $ju['debit'] - $ju['kredit'] }}</td>
	</tr>
@endif
