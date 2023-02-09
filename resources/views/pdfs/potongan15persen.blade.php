@if(  $bayar <= 60000000 )
	<td nowrap>Potongan 15 % x {{ App\Models\Classes\Yoga::buatrp(0) }}</td>
@elseif(
      $bayar > 60000000 &&
      $bayar <= 250000000
    )
	<td nowrap>Potongan 15 % x {{ App\Models\Classes\Yoga::buatrp( $bayar - 60000000) }}</td>
@else
	<td nowrap>Potongan 15 % x {{ App\Models\Classes\Yoga::buatrp( 190000000) }}</td>
@endif
