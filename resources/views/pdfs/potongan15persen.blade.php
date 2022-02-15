@if(  $bayar <= 50000000 )
	<td nowrap>Potongan 15 % x {{ App\Models\Classes\Yoga::buatrp(0) }}</td>
@elseif(  $bayar < 250000000 )
	<td nowrap>Potongan 15 % x {{ App\Models\Classes\Yoga::buatrp( $bayar - 50000000) }}</td>
@else
	<td nowrap>Potongan 15 % x {{ App\Models\Classes\Yoga::buatrp( 250000000) }}</td>
@endif
