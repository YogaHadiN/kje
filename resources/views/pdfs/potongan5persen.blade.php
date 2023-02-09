@if( $bayar <= 60000000 )
	<td nowrap>Potongan 5 % x {{\App\Models\Classes\Yoga::buatrp(  $bayar  )}}</td>
@else
	<td nowrap>Potongan 5 % x Rp. 60.000.000,-</td>
@endif
