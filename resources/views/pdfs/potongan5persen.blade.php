@if( $bayar >= 50000000 )
	<td nowrap>Potongan 5 % x Rp. 50.000.000,-</td>
@else
	<td nowrap>Potongan 5 % x {{App\Models\Classes\Yoga::buatrp(  $bayar  )}}</td>
@endif
