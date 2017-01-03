    <table class="table">
      <tbody>
        <tr>
          <td><h1>Harta / Aktiva</h1></td>
          <td><h1>Hutang / Liabilitas</h1></td>
        </tr>
        <tr>
          <td>
            <table class="table">
              <tbody>
                <tr>
                  <td colspan="3"><h3>Lancar</h3></td>
                </tr>
				 @foreach($akunAktivaLancar as $ju) 
					 @if($ju->total != 0)
						<tr>
							<td></td>
							<td>{{ $ju->id }} - {{ $ju->coa }}</td>
							<td class="text-right">{{App\Classes\Yoga::buatrp(  $ju->total  )}}</td>
						</tr>
					@endif
				 @endforeach 
                <tr>
                  <td colspan="3"><h3>Tidak Lancar</h3></td>
                </tr>
				 @foreach($akunAktivaTidakLancar as $ju) 
					 @if($ju->total != 0)
						<tr>
							<td></td>
							<td>{{ $ju->id }} - {{ $ju->coa }}</td>
							<td class="text-right">{{App\Classes\Yoga::buatrp($ju->total ) }}</td>
						</tr>
					@endif
				 @endforeach 
              </tbody>
            </table>
          </td>
          <td>
            <table class="table">
              <tbody>
                <tr>
                  <td colspan="3"><h3>Hutang</h3></td>
                </tr>
				 @foreach($akunHutang as $v) 
					<tr>
					  <td></td>
					  <td>{{ $v->id }} - {{ $v->coa }}</td>
					  <td class="text-right">{{ App\Classes\Yoga::buatrp($v->total) }}</td>
					</tr>
				 @endforeach 
                <tr>
                  <td colspan="3"><h3>Modal / Ekuitas</h3></td>
                </tr>
				 @foreach($akunModal as $v) 
					<tr>
					  <td></td>
					  <td>{{ $v->id }} - {{ $v->coa }}</td>
					  <td class="text-right">{{ App\Classes\Yoga::buatrp($v->total) }}</td>
					</tr>
				 @endforeach 
					<tr>
					  <td></td>
					  <td>301999 - Laba Tahun Berjalan</td>
					  <td class="text-right">{{ App\Classes\Yoga::buatrp($laba_tahun_berjalan) }}</td>
					</tr>
              </tbody>
            </table>
          </td>
        </tr>
		<tr>
			<td><h1 class="text-right">{{ App\Classes\Yoga::buatrp($total_harta) }}</h1></td>
          <td><h1 class="text-right">{{ App\Classes\Yoga::buatrp($total_harta) }}</h1></td>
		</tr>
      </tbody>
    </table>
  
