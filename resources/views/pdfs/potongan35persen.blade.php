@if(  $bayar <= 500000000 )
    <td nowrap>Potongan 30 % x {{ App\Models\Classes\Yoga::buatrp(0) }}</td>
@elseif(
      $bayar > 500000000 && 
      $bayar <= 5000000000
    )
    <td nowrap>Potongan 30 % x {{ App\Models\Classes\Yoga::buatrp( $bayar - 500000000 ) }}</td>
@else
    <td nowrap>Potongan 30 % x {{ App\Models\Classes\Yoga::buatrp(4500000000) }}</td>
@endif
