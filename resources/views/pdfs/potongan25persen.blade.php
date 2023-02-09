@if(  $bayar <= 250000000 )
	<td nowrap>Potongan 25 % x {{ App\Models\Classes\Yoga::buatrp(0) }}</td>
@elseif(  $bayar > 250000000 )
	<td nowrap>Potongan 25 % x {{ App\Models\Classes\Yoga::buatrp( $bayar - 250000000) }}</td>
@else
	<td nowrap>Potongan 25 % x {{ App\Models\Classes\Yoga::buatrp( 250000000) }}</td>
@endif
