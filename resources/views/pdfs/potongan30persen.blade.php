@if(  $bayar > 500000000 )
<td nowrap>Potongan 30 % x {{ App\Models\Classes\Yoga::buatrp( $bayar - 500000000 ) }}</td>
@else
<td nowrap>Potongan 30 % x {{ App\Models\Classes\Yoga::buatrp(0) }}</td>
@endif
